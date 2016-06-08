<?php
class admin_shop_tpl extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/jQueryTabs.js');
        PackageLoader::Get()->registerJSFile('/_js/select2.js');
        PackageLoader::Get()->registerJSFile('/_js/jquery.caret.js');
        PackageLoader::Get()->registerCSSFile('/_css/select2-modern.css');
        PackageLoader::Get()->registerJSFile('/_js/jquery.tablesorter.js');
        PackageLoader::Get()->registerJSFile('/_js/jquery.autosize.js');
        PackageLoader::Get()->registerJSFile('/_js/jquery.dataTables.min.js');
        PackageLoader::Get()->registerJSFile('/_js/FixedColumns.min.js');
        PackageLoader::Get()->registerJSFile('/_js/perfect-scrollbar.js');
        PackageLoader::Get()->registerCSSFile('/_css/perfect-scrollbar.css');
        PackageLoader::Get()->registerJSFile('/_js/jquery.ui.timepicker.addon.js');
        PackageLoader::Get()->registerCSSFile('/_css/jquery.ui.timepicker.addon.css');
        PackageLoader::Get()->registerJSFile('/_js/jquery.tag.it.js');
        PackageLoader::Get()->registerCSSFile('/_css/jquery.tagit.css');
        PackageLoader::Get()->registerJSFile('/_js/jquery.tooltipster.js');
        PackageLoader::Get()->registerCSSFile('/_css/jquery.tooltipster.css');
        PackageLoader::Get()->registerJSFile('/_js/jquery.textcomplete.js');
        PackageLoader::Get()->registerJSFile('/_js/jQueryFilter.js');
        PackageLoader::Get()->registerJSFile('/_js/hotkey.js');

        // подключение JS API и SelectWindow
        PackageLoader::Get()->registerJSFile('/contents/shop/api/api.js');
        PackageLoader::Get()->registerJSFile('/contents/shop/admin/selectwindow/selectwindow.js');

        $isOrder = Shop_ModuleLoader::Get()->isImported('order');
        $this->setValue('isOrderImported', $isOrder);

        $isFinance = Shop_ModuleLoader::Get()->isImported('finance');
        $this->setValue('isFinanceImported', $isFinance);

        $isContact = Shop_ModuleLoader::Get()->isImported('contact');
        $this->setValue('isContactImported', $isContact);

        $acl = array();
        try {
            $user = $this->getUser();
            $this->setValue('user', $user->makeInfoArray());
            $this->setValue('avatar', $this->getUser()->makeImageGravatar());

            // передаем все ACL user'a
            $acl = Shop::Get()->getUserService()->getUserACLArray(
                $this->getUser()
            );
            $this->setValue('acl', $acl);

            $this->setValue('emailArray', $user->getEmailArray());
        } catch (Exception $e) {

        }
        $this->setValue('ticketacl', $user->isAllowed('ticket-support'));

        try {
            $cuser = $this->getUser();

            $username = $cuser->getName().' '.$cuser->getNamelast();
            $username = trim($username);
            if (!$username) {
                $username = $cuser->getLogin();
            }
            $this->setValue('userName', $username);

            $this->setValue('userImage', $cuser->makeImageThumb(200));

            $this->setValue('menuTopArray', Shop_ModuleLoader::Get()->getTopMenuArray($cuser));
            $this->setValue('menuReportArray', Shop_ModuleLoader::Get()->getReportMenuArray($cuser));
            $this->setValue('menuSettingArray', Shop_ModuleLoader::Get()->getSettingMenuArray($cuser));
        } catch (Exception $ue) {

        }

        try {
            $this->setValue('branding', Engine::Get()->getConfigField('project-branding'));
        } catch (Exception $brandEx) {

        }

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

        $block = Engine::GetContentDriver()->getContent('shop-admin-svg');
        $this->setValue('admin_shop_svg', $block->render());

        $this->setValue('favicon', Shop::Get()->getSettingsService()->getSettingValue('favicon'));
        $this->setValue('title', Engine::GetHTMLHead()->getTitle());
        $this->setValue('year', date('Y'));
        $this->setValue('engine_includes', Engine::GetHTMLHead()->render());

        // отступы для right sidebar
        $contentID = Engine::Get()->getRequest()->getContentID();
        $contentArray = array();
        $contentArray[] = 'shop-admin-orders';
        $contentArray[] = 'shop-admin-brands';
        $contentArray[] = 'shop-admin-manage';
        $contentArray[] = 'shop-admin-orders-report-servicebusy';
        $contentArray[] = 'shop-admin-products-in-list';
        $contentArray[] = 'shop-admin-products';
        $contentArray[] = 'shop-admin-products-inlist';
        $contentArray[] = 'shop-admin-users';
        $contentArray[] = 'shop-admin-users-mass-mailing';
        $contentArray[] = 'shop-admin-users-mass-sms-mailing';
        $contentArray[] = 'issue-view';
        $contentArray[] = 'issue-index';
        $contentArray[] = 'project-index';

        if (in_array($contentID, $contentArray)) {
            $this->setValue('sidebarPlace', true);
        }

        // записываем во временную таблицу полный лог происходящего.
        // затем по cron-hour этот лог будет обработан и перенесен в
        // XShopHistory
        try {
            HistoryService::Get()->addHistoryLog();
        } catch (Exception $historyEx) {

        }

        // менеджеры
        $user = $this->getUser();
        $managers = Shop::Get()->getUserService()->getUsersManagers($this->getUser());
        $a = array();
        $currentUserId = $user->getId();
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            'selected' => $currentUserId == $x->getId(),
            );
        }
        $this->setValue('managerArray', $a);
        $this->setValue('commentTemplateArray', Shop_ShopService::Get()->getCommentTemplatesArray());

        $turboSmsLogin =  Shop::Get()->getSettingsService()->getSettingValue('sms-login');
        $turboSmsPass = Shop::Get()->getSettingsService()->getSettingValue('sms-password');
        $turboSmsSender = Shop::Get()->getSettingsService()->getSettingValue('sms-sender');
        if ($turboSmsLogin && $turboSmsPass && $turboSmsSender) {
            $this->setValue('smsSendOk', true);
        }
    }

}