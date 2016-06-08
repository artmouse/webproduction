<?php
class issue_control extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        PackageLoader::Get()->import('CommentsAPI');

        try {
            // получаем заказ
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            $user = $this->getUser();

            $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
            $this->setValue('canEdit', $canEdit);

            if ($canEdit && $this->getArgumentSecure('watch')) {
                // кнопка "следить"
                try {
                    if ($this->getArgumentSecure('watchvalue')) {
                        Shop::Get()->getShopService()->addOrderEmployer($order, $this->getUser());
                    } else {
                        Shop::Get()->getShopService()->deleteOrderEmployer($order, $this->getUser());
                    }
                } catch (ServiceUtils_Exception $se) {

                }
            }

            try {
                $this->setValue('orderId', $order->getId());

                // текущий авторизированный пользователь
                $user = $this->getUser();

                $type = $order->getType();
                $this->setValue('type', $type);

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

                $parentArray = array();
                try {
                    $parent = $order->getParent();
                    while ($parent->getType() == 'issue') {
                        $parentArray[] = array(
                            'name' => ($parent->getName()) ? $parent->getName() : $parent->getNumber(),
                            'url' => $parent->makeURLEdit()
                        );

                        if ($parent->getId() == $parent->getParentid()) {
                            throw new ServiceUtils_Exception();
                        }

                        $parent = $parent->getParent();
                    }
                } catch (ServiceUtils_Exception $se) {
                    $this->setValue('name', ($order->getName()) ? $order->getName() : $order->getNumber());
                    $this->setValue('url', $order->makeURLEdit());
                }
                $this->setValue('parentArray', array_reverse($parentArray));

                // записываем в лог, что я посмотрел задачу
                Shop::Get()->getShopService()->addOrderLogView($order, $user);

                // формируем блоки
                try{
                    $orderStatus = $order->getStatus();
                } catch (Exception $estatus) {
                    $orderStatus = false;
                }

                try{
                    $orderWorkflow = $order->getWorkflow();
                } catch (Exception $estatus) {
                    $orderWorkflow = false;
                }

                if ($orderStatus) {
                    $blocksArray = Interface_Block_Loader::Get()->getContentArrayByStatus($orderStatus);

                } else {
                    if ($orderWorkflow) {
                        $blocksArray = Interface_Block_Loader::Get()->getIssueBlocksDefaultArray(
                            $orderWorkflow->getType()
                        );
                    } else {
                        $blocksArray = Interface_Block_Loader::Get()->getIssueBlocksDefaultArray();
                    }
                }


                if ($this->getArgumentSecure('ok') || $this->getArgumentSecure('setting-info-ok')) {
                    try {
                        SQLObject::TransactionStart();
                        // первый раз для сохранения данных
                        $blockTmpArray = array();

                        $event = Events::Get()->generateEvent('shopOrderEditBefore');
                        $event->setOrder($order);
                        $event->notify();

                        foreach ($blocksArray as $structureId => $structure) {
                            if (!$structure) {
                                continue;
                            }

                            foreach ($structure as $block) {
                                if ($block['contentId']
                                    && Engine::GetContentDataSource()->getDataByID($block['contentId'])
                                ) {
                                    $blockTmpArray[] = $block;

                                }
                            }
                        }

                        uasort($blockTmpArray, array($this, '_sortBlockArrayByPriority'));

                        foreach ($blockTmpArray as $block) {
                            $block_structure = Engine::GetContentDriver()->getContent($block['contentId']);
                            $block_structure->setValue('order', $order);
                            $block_structure->render();
                        }

                        if ($canEdit && $this->getArgumentSecure('custom_status_menu')) {
                            Shop::Get()->getShopService()->updateOrderStatus(
                                $user,
                                $order,
                                $this->getArgumentSecure('custom_status_menu')
                            );
                        }

                        $event = Events::Get()->generateEvent('shopOrderEditAfter');
                        $event->setOrder($order);
                        $event->notify();

                        SQLObject::TransactionCommit();

                        $this->setValue('message', 'ok');
                    } catch (ServiceUtils_Exception $te) {
                        SQLObject::TransactionRollback();

                        if (PackageLoader::Get()->getMode('debug')) {
                            print $te;
                        }

                        if ($te->getErrorText()) {
                            $this->setValue('showErrorMessage', $te->getErrorText());
                        }

                        Engine::GetURLParser()->setArgument('message', 'error');

                        $errorsArray = $te->getErrorsArray();
                        foreach ($errorsArray as $error) {
                            if (substr_count($error, ':lack')) {
                                $errorsArray['lack'] = 'lack';
                            }
                        }

                        $this->setValue('message', 'error');
                        $this->setValue('errorsArray', $errorsArray);

                        $this->setValue(
                            'errorText',
                            implode(
                                '<br />',
                                Shop_ContentErrorHandler::Get()->getErrorValueArray($te)
                            )
                        );

                    }
                }

                // второй раз для корректного вывода данных
                if ($orderStatus) {
                    $blocksArray = Interface_Block_Loader::Get()->getContentArrayByStatus($orderStatus);

                } else {
                    if ($orderWorkflow) {
                        $blocksArray = Interface_Block_Loader::Get()->getIssueBlocksDefaultArray(
                            $orderWorkflow->getType()
                        );
                    } else {
                        $blocksArray = Interface_Block_Loader::Get()->getIssueBlocksDefaultArray();
                    }
                }

                foreach ($blocksArray as $structureId => $structure) {
                    if (!$structure) {
                        continue;
                    }

                    $html = '';
                    foreach ($structure as $block) {
                        if ($block['contentId'] && Engine::GetContentDataSource()->getDataByID($block['contentId'])) {
                            $block_structure = Engine::GetContentDriver()->getContent($block['contentId']);
                            $block_structure->setValue('order', $order);
                            $block_structure->setValue('process', true);

                            $html.= $block_structure->render();
                        }
                    }
                    $this->setValue('block_structure_'.$structureId, $html);
                }

                try {
                    $tabMenuWorkflow = new XShopWorkflowMenu();
                    $tabMenuWorkflow->setWorkflowid($order->getWorkflow()->getId());
                    $tabMenuWorkflow->setName('parent');
                    if (!$tabMenuWorkflow->getNext()) {
                        throw new ServiceUtils_Exception();
                    }

                    $objParent = $this->_getWorkflowParentOrderWithMenu($order);

                    $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
                    $menu->setValue('order', $objParent);
                    $menu->setValue('issue', $order);
                    $menu->setValue('selected', $order->getWorkflow()->getType());
                    $this->setValue('block_menu', $menu->render());
                } catch (Exception $eparent) {
                    $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
                    $menu->setValue('order', $order);
                    $menu->setValue('selected', 'view');
                    $this->setValue('block_menu', $menu->render());
                }

                $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
                $this->setValue('canEdit', $canEdit);

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
                        continue;
                    }

                    try {
                        $sum = $x->makeSum($order->getCurrency());
                    } catch (Exception $priceEx) {
                        $sum = 0;
                    }

                    $productCount = $x->getProductcount();

                    $countProductAll += $productCount;

                    $suppliercode = false;
                    try {
                        $suppliercode = $product->getSupplierCode(
                            Shop::Get()->getSupplierService()->getSupplierByID($product->getSupplierid())
                        );
                    } catch (Exception $eproductsupplier) {

                    }
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
                        'unit' => $product ? $product->getUnit() : false,
                        'articul' => $product->getArticul(),
                        'suppliercode' => $suppliercode
                    );
                }

                $this->setValue('productsArray', $a);

                $delivery2 = false;
                try {
                    $delivery2 = Shop::Get()->getDeliveryService()->getDeliveryByID($order->getDeliveryid());
                } catch (Exception $e) {
                    1;
                }

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
                                1;
                            }
                        }
                    }

                    $this->setValue('showOrderMenu', $category->getShowOrderMenu());
                } catch (Exception $e) {
                    1;
                }
                $this->setValue('statusNext2Array', $statusNextArray);

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

                Engine::GetHTMLHead()->setTitle($order->makeName());


            } catch (ServiceUtils_Exception $ge) {

                if ($ge->getMessage() == 'access') {
                    $this->setValue('redirectUrl', '/admin/customorder/'.$type.'/');
                    $this->setValue('message', 'access');
                    //throw new ServiceUtils_Exception('403', 403);

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

    /**
     * Получить родительский menu если это возможно.
     *
     * @param ShopOrder $order
     *
     * @return XShopWorkflowMenu
     */
    private function _getWorkflowParentOrderWithMenu(ShopOrder $order, $recursionArray = array()) {
        $parent = $order->getParent();

        // защита от рекурсии
        if (in_array($parent->getId(), $recursionArray)) {
            throw new ServiceUtils_Exception();
        }

        $recursionArray[] = $parent->getId();

        $parentWorkflow = $parent->getWorkflow();
        $tabMenuWorkflow = new XShopWorkflowMenu();
        $tabMenuWorkflow->setWorkflowid($parentWorkflow->getId());
        $count = 0;

        while ($x = $tabMenuWorkflow->getNext()) {
            try {
                $parentObj = $this->_getWorkflowParentOrderWithMenu($parent, $recursionArray);
            } catch (Exception $eparent) {
                $parentObj = false;
            }

            if ($x->getName() == 'parent' && $parentObj) {
                return $parentObj;
            } elseif ($x->getName() != 'closed') {
                $count++;
            }
        }

        if ($count) {
            return $parent;
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Сортирует массив по приоритету
     */
    private function _sortBlockArrayByPriority($a, $b) {
        if (@$a['priority'] == @$b['priority']) {
            return 0;
        }
        return (@$a['priority'] > @$b['priority']) ? -1 : 1;
    }
}