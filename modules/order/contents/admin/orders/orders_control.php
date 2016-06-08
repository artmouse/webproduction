<?php
class orders_control extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        PackageLoader::Get()->import('CommentsAPI');

        try {
            // получаем заказ
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            try {

                if (Shop_ModuleLoader::Get()->isModuleInModulesArray('box')
                    && !Engine::Get()->getConfigFieldSecure('static-shop-menu')
                ) {
                    $urlRedirect = $order->makeURLEdit();
                    header('Location: '.$urlRedirect);
                    exit();
                } elseif ($order->isProject()) {
                    $urlRedirect = Engine::GetLinkMaker()->makeURLByContentIDParam(
                        'admin-project-control',
                        $order->getId()
                    );
                    header('Location: '.$urlRedirect);
                    exit();
                } elseif ($order->isIssue()) {
                    $urlRedirect = Engine::GetLinkMaker()
                        ->makeURLByContentIDParam('admin-issue-control', $order->getId());
                    header('Location: '.$urlRedirect);
                    exit();
                }

                // текущий авторизированный пользователь
                $user = $this->getUser();

                // проверка прав пользователя на просмотр/управление этим заказом
                if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                    throw new ServiceUtils_Exception('access');
                }

                // referer url
                $referer = @$_SERVER['HTTP_REFERER'];
                if (!preg_match('#admin/shop/orders/[\d]+#iusD', $referer, $r)) {
                    @session_start();
                    @$_SESSION['order-referer'] = $referer;
                }

                $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
                $this->setValue('canEdit', $canEdit);

                // записываем в лог, что я посмотрел задачу
                Shop::Get()->getShopService()->addOrderLogView($order, $user);

                if ($canEdit && $this->getControlValue('ok') && $this->getControlValue('menu_statusid')) {
                    try {

                        $event = Events::Get()->generateEvent('shopOrderEditBefore');
                        $event->setOrder($order);
                        $event->notify();

                        // обновляем статус
                        $result = Shop::Get()->getShopService()->updateOrderStatus(
                            $user,
                            $order,
                            $this->getControlValue('menu_statusid')
                        );

                        $event = Events::Get()->generateEvent('shopOrderEditAfter');
                        $event->setOrder($order);
                        $event->notify();


                        if (Engine::GetURLParser()->getArgumentSecure('message') != 'error') {
                            Engine::GetURLParser()->setArgument('message', 'ok');
                        }
                    } catch (ServiceUtils_Exception $te) {

                        if (PackageLoader::Get()->getMode('debug')) {
                            print $te;
                        }

                        Engine::GetURLParser()->setArgument('message', 'error');

                        $this->setValue('message', 'error');
                        $this->setValue('errorsArray', $te->getErrorsArray());

                        $this->setValue(
                            'errorText',
                            implode(
                                '<br />',
                                Shop_ContentErrorHandler::Get()->getErrorValueArray($te)
                            )
                        );
                    }
                }

                // режим box?
                $isBox = Engine::Get()->getConfigFieldSecure('project-box');
                $this->setValue('box', $isBox);
                $workflowVisualEnable = Engine::Get()->getConfigFieldSecure('workflow-visual-enable');


                // сохраняем комментарий
                $block_comment = Engine::GetContentDriver()->getContent('shop-admin-orders-control-block-comment');
                $block_comment->setValue('order', $order);
                $block_comment->render();

                $block_product_list = Engine::GetContentDriver()->getContent(
                    'shop-admin-orders-control-block-product-list'
                );
                $this->setValue('block_product_list', $block_product_list->render());

                $block_info = Engine::GetContentDriver()->getContent('shop-admin-orders-control-block-info');
                $this->setValue('block_info', $block_info->render());

                // отображаем комментарии
                $block_comment = Engine::GetContentDriver()->getContent('shop-admin-orders-control-block-comment');
                $block_comment->setValue('order', $order);
                $block_comment->setValue('view', true);
                $this->setValue('block_comment', $block_comment->render());

                $block_processorform = Engine::GetContentDriver()->getContent(
                    'shop-admin-orders-control-block-processorform'
                );
                $block_processorform->setValue('order', $order);
                $this->setValue('block_processorform', $block_processorform->render());

                if ($isBox || $workflowVisualEnable) {
                    $block_workflow = Engine::GetContentDriver()
                        ->getContent('shop-admin-orders-control-block-workflow');
                    $this->setValue('block_workflow', $block_workflow->render());
                }

                $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
                $menu->setValue('order', $order);
                $menu->setValue('selected', 'view');
                $this->setValue('block_menu', $menu->render());

                if ($this->getArgumentSecure('message' == 'ok')) {
                    $this->setValue('message', 'ok');

                    // редирект
                    header('Location: '.$order->makeURLEdit().'?message=ok');
                }

                if (Engine::Get()->getConfigFieldSecure('oneclick-enable')) {
                    $this->setValue('oneclickEnable', true);
                }

                // получаем все товары в заказе
                $orderproducts = $order->getOrderProducts();

                $a = array();
                $countProductAll = 0;
                while ($x = $orderproducts->getNext()) {
                    $product = false;
                    try {
                        // productid может быть не действительный,
                        // поэтому заключаем в try-catch
                        $product = $x->getProduct();
                    } catch (Exception $e) {

                    }

                    try {
                        $sum = $x->makeSum($order->getCurrency());
                    } catch (Exception $priceEx) {
                        $sum = 0;
                    }

                    $productCount = $x->getProductcount();

                    $countProductAll += $productCount;

                    // товары
                    @$a[] = array(
                        'id' => $x->getId(),
                        'name' => htmlspecialchars($x->getProductname()),
                        'productid' => $x->getProductid(),
                        'productUrl' => $product ? $product->makeURLEdit():false,
                        'count' => (float) $productCount,
                        'price' => $x->getProductprice(),
                        'sum' => $sum,
                        'currencySym' => $order->getCurrency()->getSymbol(),
                        'unit' => $product ? $product->getUnit() : false
                    );
                }

                $this->setValue('productsArray', $a);

                $delivery2 = false;
                try {
                    $delivery2 = Shop::Get()->getDeliveryService()->getDeliveryByID($order->getDeliveryid());
                } catch (Exception $e) {

                }

                // сумма заказа
                if ($delivery2 && $delivery2->getPaydelivery()) {
                    $this->setValue('totalSum', $order->getSum() + $order->getDeliveryprice());
                } else {
                    $this->setValue('totalSum', $order->getSum());
                    $this->setValue('payDelivery', true);
                }

                $this->setValue('deliveryPrice', $order->getDeliveryprice()); // стоимость доставки
                $this->setValue('currency', $order->getCurrency()->getSymbol());
                $this->setValue('orderName', $order->makeName());
                $this->setValue('discountSum', $order->getDiscountsum());

                // исполнители
                $watchers = Shop::Get()->getShopService()->getOrderUserNotifyArray($order, '');
                $a = array();
                foreach ($watchers as $x) {
                    try {
                        $a[] = array(
                            'id' => $x->getId(),
                            'name' => $x->makeName(true, 'lfm'),
                            'url' => $x->makeURLEdit(),
                        );
                    } catch (Exception $e) {

                    }
                }
                $this->setValue('watcherArray', $a);

                // заголовок страницы
                Engine::GetHTMLHead()->setTitle($order->makeName());

                // список активных заказов
                $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
                $orders->setDateclosed('0000-00-00 00:00:00');
                $orders->setOrder('id', 'DESC');
                $orders->setLimitCount(100);

                if (Engine::Get()->getConfigFieldSecure('active-orders-to-manager')) {
                    $orders->setManagerid($this->getUser()->getId());
                }
                
                $a = array();
                while ($x = $orders->getNext()) {
                    try {
                        $color = $x->getStatus()->getColour();
                    } catch (Exception $e) {
                        $color = false;
                    }

                    $a[] = array(
                        'id' => $x->getId(),
                        'clientName' => htmlspecialchars($x->getClientname()),
                        'color' => $color,
                        'url' => $x->makeURLEdit(),
                    );
                }
                $this->setValue('activeOrderArray', $a);

                // статусы заказа по workflow
                $statusNextArray = array();
                try {
                    $category = $order->getWorkflow();

                    $statusChanges = new XShopOrderStatusChange();
                    $statusChanges->filterCategoryid($category->getId());
                    $statusChanges->filterElementfromid($order->getStatusid());
                    $statusesArray = array();
                    while ($x = $statusChanges->getNext()) {
                        if ($x->getElementtoid() != $order->getStatusid()) {
                            try {
                                $orderStatus = Shop::Get()->getShopService()->getStatusByID($x->getElementtoid());

                                $statusNextArray[$orderStatus->getId()] = array(
                                    'id' => $orderStatus->getId(),
                                    'name' => $orderStatus->getName(),
                                    'colour' => $orderStatus->getColour()
                                );
                            } catch (ServiceUtils_Exception $sse) {

                            }
                        }
                    }
                } catch (Exception $e) {

                }
                $this->setValue('statusNextArray', $statusNextArray);

            } catch (ServiceUtils_Exception $ge) {

                if ($ge->getMessage() == 'access') {
                    
                    $this->setValue('message', 'access');
                    
                } else {

                    throw new ServiceUtils_Exception('500 Internal Server Error', 500);
                }

            }

        } catch (ServiceUtils_Exception $ge) {

            if ($ge->getCode() == 500) {

                LogService::Get()->add();
                Engine::Get()->getRequest()->setContentServerError();
                return;

            }

            if ($ge->getCode() == 403) {

                Engine::Get()->getRequest()->setContentID(403);
                return;

            }

            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }


            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}