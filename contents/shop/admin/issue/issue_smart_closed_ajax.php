<?php
class issue_smart_closed_ajax extends Engine_Class {

    public function process() {
        try {
            // получаем заказ
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            // текущий авторизированный пользователь
            $user = $this->getUser();

            if (!$this->getControlValue('statusid')) {
                // проверка прав пользователя на просмотр/управление этим заказом
                if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                    throw new ServiceUtils_Exception();
                }
            }

            $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
            $this->setValue('canEdit', $canEdit);

            // записываем в лог, что я посмотрел задачу
            Shop::Get()->getShopService()->addOrderLogView($order, $user);

            $isClosed = $order->isClosed();

            if ($canEdit && $this->getControlValue('statusid')) {
                try {
                    SQLObject::TransactionStart();
                    // обновляем статус
                    Shop::Get()->getShopService()->updateOrderStatus(
                        $user,
                        $order,
                        $this->getControlValue('statusid')
                    );

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

            $changeClosed = false;
            if ($order->isClosed() != $isClosed) {
                $changeClosed = true;
            }

            $block_info = Engine::GetContentDriver()->getContent('admin-issue-block-info');
            $block_info->render();

            $block_comment = Engine::GetContentDriver()->getContent('shop-admin-orders-control-block-comment');
            $block_comment->setValue('order', $order);
            $block_comment->render();

            if ($this->getArgumentSecure('message') == 'error') {
                throw new ServiceUtils_Exception();
            }

            // next issue
            $nextname = trim($this->getArgumentSecure('nextname'));
            if ($nextname) {

                $nextdate = $this->getArgumentSecure('nextdate');
                if (!$nextdate) {
                    $nextdate = DateTime_Object::Now()->addDay(1)->setFormat('Y-m-d 00:00:00')->__toString();
                }

                $issue = IssueService::Get()->addIssue(
                    $user,
                    $nextname,
                    $this->getArgumentSecure('nextdescription'),
                    $order->getManagerid(),
                    $order->getCategoryid(),
                    $nextdate,
                    $order->getUserid(),
                    $order->getParentid()
                );

                $issue->setPrevid($order->getId());
                $issue->update();

                $order->setNextid($issue->getId());
                $order->update();
            }

            $block_issue = Engine::GetContentDriver()->getContent('calendar-block-issue');
            $block_issue->setValue('issue', $order);

            echo json_encode(array('issue' => $block_issue->render(), 'changeClosed' => $changeClosed));
            exit;
        } catch (Exception $e) {
            echo json_encode(array('error' => isset($errorText)?$errorText:''));
            exit;
        }
    }

}