<?php
class box_admin_menu_block extends Engine_Class {

    public function process() {
        try {
            $this->setValue('branding', Engine::Get()->getConfigField('project-branding'));
        } catch (Exception $brandEx) {

        }


        $cuser = $this->getUser();
        $this->setValue('cuserID', $cuser->getId());

        $username = $cuser->getName().' '.$cuser->getNamelast();
        $username = trim($username);
        if (!$username) {
            $username = $cuser->getLogin();
        }
        $this->setValue('userName', $username);

        $this->setValue('userImage', $cuser->makeImageThumb(200));

        $this->setValue('notification_block', $cuser->getNotificationblock());

        $this->setValue('menuTopArray', Shop_ModuleLoader::Get()->getTopMenuArray($cuser));
        $this->setValue('menuReportArray', Shop_ModuleLoader::Get()->getReportMenuArray($cuser));
        $this->setValue('menuSettingArray', Shop_ModuleLoader::Get()->getSettingMenuArray($cuser));

        $this->setValue('user', $cuser->makeInfoArray());
        $this->setValue('avatar', $this->getUser()->makeImageGravatar());

        $this->setValue('showOrderMenu', Engine::Get()->getConfigFieldSecure('static-shop-menu'));

        // передаем все ACL user'a
        $acl = Shop::Get()->getUserService()->getUserACLArray(
            $this->getUser()
        );
        $this->setValue('acl', $acl);

        $this->setValue('emailArray', $cuser->getEmailArray());

        // переопределение меню
        try {
            $menuArray = Engine::Get()->getConfigField('project-menu');

            // для каждого пункта проверяем права доступа
            foreach ($menuArray as $url => $name) {
                try {
                    $contentID = Engine::Get()->getRequest()->defineContentID($url);

                    if (!$contentID) {
                        continue;
                    }

                    $contentData = Engine::GetContentDataSource()->getDataByID($contentID);
                    $roleArray = $contentData['role'];
                    if (!$roleArray) {
                        $roleArray = array();
                    }

                    foreach ($roleArray as $role) {
                        if ($this->getUser()->isDenied($role)) {
                            unset($menuArray[$url]);
                            break;
                        }
                    }
                } catch (Exception $contentEx) {

                }
            }

            $this->setValue('menuArray', $menuArray);
        } catch (Exception $e) {

        }

        $this->setValue('ticketacl', $cuser->isAllowed('ticket-support'));

        // список категорий (workflow)
        $category = Shop::Get()->getShopService()->getWorkflowsActive($this->getUser());
        $a = array();
        while ($x = $category->getNext()) {
            $url = false;
            if ($x->getType() == 'issue' && $cuser->isAllowed('issue')) {
                $url = Engine::GetLinkMaker()->makeURLByContentIDParam('issue-add', $x->getId(), 'workflowid');
                $this->setValue('workflowIssue', true);
            }
            if ($x->getType() == 'project' && $cuser->isAllowed('project')) {
                $url = Engine::GetLinkMaker()->makeURLByContentIDParam('admin-project-add', $x->getId(), 'workflowid');
                $this->setValue('workflowProject', true);
            } elseif ($x->getType() == 'order' && $cuser->isAllowed('orders')) {
                $url = Engine::GetLinkMaker()->makeURLByContentIDParam(
                    'shop-admin-orders-add',
                    $x->getId(),
                    'workflowid'
                );
                $this->setValue('workflowOrder', true);
            } else {
                $url = Engine::GetLinkMaker()->makeURLByContentIDParams(
                    'custom-issue-shop-add',
                    array(
                        'workflowid' => $x->getId(),
                        'type' => $x->getType()
                    )
                );
                $this->setValue('workflowIssue', true);
            }

            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                'url' => $url,
            );
        }
        $this->setValue('workflowArray', $a);

        if (!Engine::Get()->getConfigFieldSecure('static-shop-menu')) {
            // типы workflow
            $workflowType = new XShopWorkflowType();
            $workflowTypeArray = array();
            while ($x = $workflowType->getNext()) {
                $url = "/admin/customorder/".$x->getType()."/add/";
                if ($x->getContentId()) {
                    try{
                        $content = Engine_ContentDriver::Get()->getContent($x->getContentId())->getContentData();
                        if ($content['url']) {
                            $url = $content['url'];
                        }
                    } catch (Exception $econten) {

                    }
                }

                $workflowTypeArray[] = array(
                    'name' => $x->getName(),
                    'mname' => $x->getMultiplename(),
                    'type' => $x->getType(),
                    'typeaddpage' => $x->getTypeaddpage(),
                    'url' => $url
                );
            }
            $this->setValue('workflowTypeArray', $workflowTypeArray);
        }

        $turboSmsLogin =  Shop::Get()->getSettingsService()->getSettingValue('sms-login');
        $turboSmsPass = Shop::Get()->getSettingsService()->getSettingValue('sms-password');
        $turboSmsSender = Shop::Get()->getSettingsService()->getSettingValue('sms-sender');
        if ($turboSmsLogin && $turboSmsPass && $turboSmsSender) {
            $this->setValue('smsSendOk', true);
        }
    }

}