<?php
class users_menu extends Engine_Class {

    public function process() {
        $contact = Shop::Get()->getUserService()->getUserByID(
            $this->getValue('userid')
        );

        $this->setValue('urlEdit', $contact->makeURLEdit());

        $urlDelete = Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-admin-users-delete',
            $contact->getId()
        );

        $this->setValue('urlDelete', $urlDelete);

        $urlFrom = @$_SERVER['HTTP_REFERER'];
        if ($urlFrom && @$_SESSION['contactRefererID'] != $contact->getId()) {
            $_SESSION['contactRefererURL'] = $urlFrom;
            $_SESSION['contactRefererID'] = $contact->getId();
        }
        $this->setValue('urlBack', @$_SESSION['contactRefererURL']);

        $this->setValue('id', $contact->getId());
        $this->setValue('image', $contact->makeImageThumb());
        
        try {
            $companyimg = Shop::Get()->getShopService()->getCompanyByName($contact->getCompany());
            if (!$contact->getImage() && $companyimg->getImage()) {
                $this->setValue('image', $companyimg->makeImageThumb());
            }
        } catch (Exception $exc) {
            
        }

        if ($contact->getImage()) {
            $this->setValue('bigImage', '/media/shop/'.$contact->getImage());
        }

        $description = '';
        if ($contact->getTypesex() == 'company') {
            $this->setValue('name', $contact->getCompany(), true);
            $description .= $contact->getPost();
        } else {
            $this->setValue('name', $contact->makeName(true, 'lfm'));
            $description .= $contact->getCompany();
            if ($description && $contact->getPost()) {
                $description .= ', '.$contact->getPost();
            }
        }
        if ($description) {
            $description .= "\n";
        }
        $comment = mb_substr($contact->getCommentadmin(), 0, 199);
        if ($pos = mb_strrpos($comment, '.')) {
            $description .= mb_substr($comment, 0, $pos+1);
        } elseif ($pos = mb_strrpos($comment, ' ')) {
            $description .= mb_substr($comment, 0, $pos).' ...';
        } else {
            $description .= $comment;
        }
        $this->setValue('description', nl2br(htmlspecialchars($description)));

        $this->setValue('typesex', $contact->getTypesex());

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $this->setValue('box', true);

            $canEdit = Shop::Get()->getUserService()->isUserChangeAllowed($contact, $this->getUser());

            if ($canEdit) {
                $urlLegal = Engine::GetLinkMaker()->makeURLByContentIDParam(
                    'shop-admin-users-legal',
                    $contact->getId(),
                    'id'
                );
                $this->setValue('urlLegal', $urlLegal);
            }

            $this->setValue('urlEvent', $contact->makeURLEvent());

            $urlGraphics = Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-admin-users-graphics',
                $contact->getId(),
                'id'
            );
            $this->setValue('urlGraphics', $urlGraphics);

            $urlIssue = Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-admin-users-issue',
                $contact->getId(),
                'id'
            );
            $this->setValue('urlIssue', $urlIssue);

            $urlProject = Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-admin-users-project',
                $contact->getId(),
                'id'
            );
            $this->setValue('urlProject', $urlProject);

            // количество открытых задач
            $issues = IssueService::Get()->getIssuesAll($this->getUser());
            $issues->addWhereQuery(
                "(authorid={$contact->getId()} OR userid={$contact->getId()} OR managerid={$contact->getId()})"
            );
            $issues->setDateclosed('0000-00-00 00:00:00');
            $issues->setType('issue');
            $this->setValue('issueCount', $issues->getCount());
            // количество открытых проектов
            $issues->setType('project');
            $this->setValue('projectCount', $issues->getCount());
        }

        $urlOrder = Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-users-order', $contact->getId(), 'id');
        $this->setValue('urlOrder', $urlOrder);

        if (class_exists('IssueService')) {
            // количество открытых заказов
            $issues = IssueService::Get()->getIssuesAll($this->getUser());
            $issues->addWhereArray(array('', 'order'), 'type');
            $issues->addWhereQuery(
                "(authorid={$contact->getId()} OR userid={$contact->getId()} OR managerid={$contact->getId()})"
            );
            $issues->setDateclosed('0000-00-00 00:00:00');
            $this->setValue('orderCount', $issues->getCount());
        }

        $cuser = $this->getUser();
        if ($cuser->getLevel() >= 3) {
            $urlpermissions = Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-admin-users-permissions',
                $contact->getId(),
                'id'
            );
            $this->setValue('urlPermissions', $urlpermissions);
        }

        // дополнительные табы от модулей
        $moduleTabArray = Shop_ModuleLoader::Get()->getUserTabArray($cuser);
        foreach ($moduleTabArray as $k => $moduleTabInfo) {
            $moduleTabArray[$k]['url'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
                $moduleTabInfo['contentID'],
                $contact->getId()
            );
        }
        $this->setValue('moduleTabArray', $moduleTabArray);

        if (Shop_ModuleLoader::Get()->isModuleInModulesArray('box')
            && !Engine::Get()->getConfigFieldSecure('static-shop-menu')
        ) {
            $issues = Shop::Get()->getShopService()->getOrdersAll(false, true);
            $issues->setDeleted(0);
            $issues->addWhereQuery(
                "(authorid={$contact->getId()} OR userid={$contact->getId()} OR managerid={$contact->getId()})"
            );
            $issues->setDateclosed('0000-00-00 00:00:00');

            $workflowTypeArray = array();
            $workflowType = new XShopWorkflowType();
            while ($x = $workflowType->getNext()) {
                $issuesTmp = clone $issues;
                $issuesTmp->setType($x->getType());
                $typeCount = $issuesTmp->getCount();

                $workflowTypeArray[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getMultiplename() ? $x->getMultiplename() : $x->getName(),
                    'type' => $x->getType(),
                    'count' => $typeCount,
                    'url' => '/admin/shop/users/custom/'.$contact->getId().'/'.$x->getType().'/'
                );
            }

            $this->setValue('workflowTypeArray', $workflowTypeArray);
            $this->setValue('dynamic_menu', true);
            $this->setValue('menuColor', Shop::Get()->getSettingsService()->getSettingValue('color-menu'));
        }
    }

}