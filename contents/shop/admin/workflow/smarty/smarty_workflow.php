<?php
class smarty_workflow extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID($this->getArgument('id'));

            // текущий авторизированный пользователь
            $user = $this->getUser();

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                throw new ServiceUtils_Exception();
            }

            $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
            $this->setValue('canEdit', $canEdit);

            // записываем в лог, что я посмотрел задачу
            Shop::Get()->getShopService()->addOrderLogView($order, $user);

            $noProjectLine = false;
            if ($order->getType() == 'project'
                && !Shop::Get()->getSettingsService()->getSettingValue('project-show-line-project')
            ) {
                $noProjectLine = true;
            }

            $block_info = Engine::GetContentDriver()->getContent('admin-issue-block-info');
            $block_info->setValue('noProjectLine', $noProjectLine);
            $this->setValue('block_info', $block_info->render());

            $block_comment = Engine::GetContentDriver()->getContent('shop-admin-orders-control-block-comment');
            $block_comment->setValue('order', $order);
            $this->setValue('block_comment', $block_comment->render());

            $block_processorform = Engine::GetContentDriver()->getContent(
                'shop-admin-orders-control-block-processorform'
            );
            $block_processorform->setValue('order', $order);
            $this->setValue('block_processorform', $block_processorform->render());

            $this->setValue('orderID', $order->getId());

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
        } catch (Exception $e) {

        }
    }
}