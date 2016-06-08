<?php
class issue_calendar_popup extends Engine_Class {

    public function process() {
        try {
            PackageLoader::Get()->registerJSFile('/_js/jsPlumb.js');
            $order = Shop::Get()->getShopService()->getOrderByID($this->getArgument('id'));

            $this->setValue('orderID', $order->getId());
            $this->setValue('url', $order->makeURLEdit());
            // текущий авторизированный пользователь
            $user = $this->getUser();

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                $this->setValue('notAccess', true);
                return;
            }

            $type = $order->getType();
            $this->setValue('type', $type);

            $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
            $this->setValue('canEdit', $canEdit);

            // записываем в лог, что я посмотрел задачу
            Shop::Get()->getShopService()->addOrderLogView($order, $user);

            $isClosed = $order->isClosed();

            // формируем блоки
            try{
                $blocksArray = Interface_Block_Loader::Get()->getContentArrayByStatus($order->getStatus());

                if ($canEdit && ($this->getArgumentSecure('ok') || $this->getArgumentSecure('setting-info-ok'))) {
                    foreach ($blocksArray as $structureId => $structure) {
                        if (!$structure) {
                            continue;
                        }

                        foreach ($structure as $block) {
                            if ($block['contentId']
                                && Engine::GetContentDataSource()->getDataByID($block['contentId'])
                            ) {
                                $block_structure = Engine::GetContentDriver()->getContent($block['contentId']);
                                $block_structure->setValue('order', $order);
                                $block_structure->render();
                            }
                        }
                    }

                    if ($this->getArgumentSecure('statusbuttonid')) {
                        try {
                            SQLObject::TransactionStart();

                            $event = Events::Get()->generateEvent('shopOrderEditBefore');
                            $event->setOrder($order);
                            $event->notify();

                            // обновляем статус
                            Shop::Get()->getShopService()->updateOrderStatus(
                                $user,
                                $order,
                                $this->getArgumentSecure('statusbuttonid')
                            );

                            $event = Events::Get()->generateEvent('shopOrderEditAfter');
                            $event->setOrder($order);
                            $event->notify();

                            SQLObject::TransactionCommit();
                        } catch (ServiceUtils_Exception $te) {
                            SQLObject::TransactionRollback();

                            Engine::GetURLParser()->setArgument('message', 'error');

                            $errorText = implode(
                                '<br />',
                                Shop_ContentErrorHandler::Get()->getErrorValueArray($te)
                            );
                        }
                    }

                    if ($this->getArgumentSecure('message') == 'error') {
                        throw new ServiceUtils_Exception();
                    }

                    $changeClosed = false;
                    if ($order->isClosed() != $isClosed) {
                        $changeClosed = true;
                    }

                    $block_issue = Engine::GetContentDriver()->getContent('calendar-block-issue');
                    $block_issue->setValue('issue', $order);

                    echo json_encode(array('issue' => $block_issue->render(), 'changeClosed' => $changeClosed));
                    exit;
                } else {
                    $blocksArray = Interface_Block_Loader::Get()->getContentArrayByStatus($order->getStatus());

                    foreach ($blocksArray as $structureId => $structure) {
                        if (!$structure) {
                            continue;
                        }

                        $html = '';
                        foreach ($structure as $block) {
                            if ($block['contentId']
                                && Engine::GetContentDataSource()->getDataByID($block['contentId'])
                            ) {
                                $block_structure = Engine::GetContentDriver()->getContent($block['contentId']);
                                $block_structure->setValue('order', $order);
                                $block_structure->setValue('process', true);

                                $html.= $block_structure->render();
                            }
                        }
                        $this->setValue('block_structure_'.$structureId, $html);
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

                                }
                            }
                        }
                    } catch (Exception $e) {

                    }

                    $this->setValue('statusNextArray', $statusNextArray);
                }


            } catch (ServiceUtils_Exception $e) {
                $errorText = implode(
                    '<br />',
                    Shop_ContentErrorHandler::Get()->getErrorValueArray($e)
                );

                echo json_encode(array('error' => isset($errorText)?$errorText:''));
                exit;
            }

        } catch (Exception $e) {

        }
    }

}