<?php
class custom_child extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            $user = $this->getUser();

            $type = $this->getArgument('type');

            if ($user->isDenied($type)) {
                // вычисляем путь к шаблону
                $templateName = Engine::Get()->getConfigFieldSecure('shop-template');
                $templatePath = PackageLoader::Get()->getProjectPath().'/templates/'.$templateName.'/';

                $this->setField('filehtml', $templatePath.'/error/error_deny.html');
                $this->setField('filephp', false);
                return;
            }

            $this->setValue('orderid', $order->getId());
            $this->setValue('orderName', $order->makeName());

            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_zadachi_').$order->makeName()
            );

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                throw new ServiceUtils_Exception();
            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', $this->getArgument('orderType'));
            $this->setValue('block_menu', $menu->render());

            // блок быстрого добавления задачи
            $block = Engine::GetContentDriver()->getContent('issue-add-quick');
            $block->setValue('projectid', $order->getId());
            $block->setValue('typeArray', array($this->getArgument('orderType')));
            if ($this->getArgumentSecure('newmanagerid') === false) {
                $block->setControlValue('newmanagerid', $order->getManagerid());
            }
            $this->setValue('block_issue_add_quick', $block->render());

            // задачи
            $issues = IssueService::Get()->getIssuesAll($user);
            $issues->setType($this->getArgument('orderType'));

            $issueIdArray = array();
            $orderTreeArray = Shop::Get()->getShopService()->makeOrderTreeArray($user, $order->getId());
            foreach ($orderTreeArray as $orderTree) {
                $issueIdArray[] = $orderTree->getId();
            }

            $issueIdArray[] = $order->getId();
            $issues->filterParentid($issueIdArray);

            $list = Engine::GetContentDriver()->getContent('issue-list');
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

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}