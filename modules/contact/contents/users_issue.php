<?php
class users_issue extends Engine_Class {

    public function process() {
        try {
            $user = Shop::Get()->getUserService()->getUserByID(
                $this->getArgument('id')
            );

            if (!Shop::Get()->getUserService()->isUserViewAllowed($user, $this->getUser())) {
                throw new ServiceUtils_Exception('user');
            }

            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_zadachi_').$user->makeName()
            );

            $typeSelected = 'issue';

            if (Shop_ModuleLoader::Get()->isModuleInModulesArray('box')
                && !Engine::Get()->getConfigFieldSecure('static-shop-menu')
                && $this->getArgumentSecure('type')
            ) {
                $typeSelected = $this->getArgumentSecure('type');


                $workflowtype = new XShopWorkflowType();
                $workflowtype->setType($this->getArgumentSecure('type'));
                $workflowtype = $workflowtype->getNext();
                if ($workflowtype) {
                    Engine::GetHTMLHead()->setTitle(
                        $workflowtype->getMultiplename() ? $workflowtype->getMultiplename() : $workflowtype->getName()
                        .' '.$user->makeName()
                    );
                }
            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-users-menu');
            $menu->setValue('selected', $typeSelected);
            $menu->setValue('userid', $user->getId());
            $this->setValue('menu', $menu->render());

            // задачи
            $issues = IssueService::Get()->getIssuesAll($this->getUser());
            $issues->setDeleted(0);
            if (Shop_ModuleLoader::Get()->isModuleInModulesArray('box')
                && !Engine::Get()->getConfigFieldSecure('static-shop-menu')
                && $this->getArgumentSecure('type')
            ) {
                $issues->setType($this->getArgumentSecure('type'));
            } else {
                $issues->setType('issue');
            }

            $issues->addWhereQuery(
                "(authorid={$user->getId()} OR userid={$user->getId()} OR managerid={$user->getId()})"
            );

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