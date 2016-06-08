<?php
class project_orders extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            $user = $this->getUser();

            $this->setValue('orderid', $order->getId());
            $this->setValue('orderName', $order->makeName());

            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_zakazi_').$order->makeName()
            );

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                throw new ServiceUtils_Exception('access');
            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', 'order');
            $this->setValue('block_menu', $menu->render());

            // блок быстрого добавления задачи
            /*$block = Engine::GetContentDriver()->getContent('issue-add-quick');
            $block->setValue('projectid', $order->getId());
            $block->setValue('typeArray', array('', 'order'));
            if (!$this->getArgumentSecure('newmanagerid')) {
                $block->setControlValue('newmanagerid', $order->getManagerid());
            }
            $this->setValue('block_issue_add_quick', $block->render());*/

            // задачи
            $issues = IssueService::Get()->getIssuesAll($user);
            $issues->unsetField('type');
            $issues->addWhereArray(array('', 'order'), 'type');

            if (Engine::Get()->getConfigFieldSecure('content-project-tab-order') == 'clientOrder') {
                // заказы клиента
                try {
                    $issues->setUserid($order->getClient()->getId());
                } catch (Exception $eclient) {
                    $issues = false;
                }
            } elseif (Engine::Get()->getConfigFieldSecure('content-project-tab-order') == 'project&clientOrder') {
                // заказы клиента и заказы проекта
                try {
                    $issues->addWhereQuery(
                        "(`userid` = ".$order->getClient()->getId()." OR `parentid` = ".$order->getId().")"
                    );
                } catch (Exception $eclient) {
                    $issues->setParentid($order->getId());
                }
            } elseif (Engine::Get()->getConfigFieldSecure('content-project-tab-order') == 'project|clientOrder') {
                // заказы проекта, а если их нет, то заказы клиента
                $issueClone = clone $issues;
                try {
                    $issues->setParentid($order->getId());
                    if (!$issues->getCount()) {
                        $issues = $issueClone;
                        $issues->setUserid($order->getUserid());
                    }
                } catch (Exception $eclient) {
                    $issues = false;
                }

            } elseif (Engine::Get()->getConfigFieldSecure('content-project-tab-order') == 'client|projectOrder') {
                // заказы клиента, а если их нет, то заказы проекта
                $issueClone = clone $issues;
                try {
                    $issues->setUserid($order->getUserid());
                    if (!$issues->getCount()) {
                        $issues = $issueClone;
                        $issues->setParentid($order->getId());
                    }
                } catch (Exception $eclient) {
                    $issues = false;
                }
            } else {
                $issues->setParentid($order->getId());
            }

            $list = Engine::GetContentDriver()->getContent('issue-list');
            $list->setValue('datasource', new Datasource_Orders());
            try {
                $this->getArgument('filtershowclosed');
            } catch (Exception $e) {
                Engine::GetURLParser()->setArgument('filtershowclosed', true);
            }
            $list->setValue('issues', $issues);
            $this->setValue('block_issue', $list->render());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            if ($ge->getMessage() == 'access') {
                Engine::Get()->getRequest()->setContentID(403);
            } else {
                Engine::Get()->getRequest()->setContentNotFound();
            }
        }
    }

}