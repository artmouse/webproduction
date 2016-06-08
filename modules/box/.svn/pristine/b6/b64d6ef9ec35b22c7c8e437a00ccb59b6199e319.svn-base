<?php
include(PackageLoader::Get()->getProjectPath().'/contents/shop/admin/admin_shop_tpl.php');

class admin_shop_tpl_box extends admin_shop_tpl {

    public function process() {
        parent::process();

        PackageLoader::Get()->registerJSFile('/_js/dropzone.min.js');
        PackageLoader::Get()->registerJSFile('/_js/dropuploader.js');
        PackageLoader::Get()->registerJSFile('/_js/admin/issue-control.js');
        PackageLoader::Get()->registerJSFile('/_js/admin/comment.js');
        PackageLoader::Get()->registerJSFile('/_js/admin/admin_notification_block.js');

        $cuser = $this->getUser();

        $this->setValue(
            'dynamic_workflow_type_in_menu',
            !Engine::Get()->getConfigFieldSecure('static-shop-menu')
        );
        
        // включение AMI
        $allowCallWindow = Engine::Get()->getConfigFieldSecure('project-box-call-window');
        $this->setValue('allowCallWindow', $allowCallWindow);

        $callWindowTimeout = (int) Engine::Get()->getConfigFieldSecure('call-window-timeout');
        if ($callWindowTimeout <= 1000) {
            $callWindowTimeout = 1000;
        }
        $this->setValue('callWindowTimeout', $callWindowTimeout);
        $this->setValue('callWindowUserID', $cuser->getId());

        $block = Engine::GetContentDriver()->getContent('shop-admin-svg');
        $this->setValue('admin_shop_svg', $block->render());

        $this->setValue('commentTemplateArray', Shop::Get()->getShopService()->getCommentTemplatesArray());

        if (Shop_ModuleLoader::Get()->isImported('box')) {
            // welcome text        
            $welcome = new XWelcomeText();
            $welcome->setUserid($cuser->getId());
            if ($welcome->select()) {
                $this->setValue('welcometext', $welcome->getContent());
                $welcome->delete();
            }
        }
        
        // список всех сотрудников для подсказок в textcomplete
        $a = array();
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $managers->getNext()) {
            $name = $x->makeName(false, 'fl');
            if ($name) {
                if ($x->getPost()) {
                    $name .= ", " . $x->getPost();
                }
                $a[] = $name . ' #' . $x->getId();
            }
        }
        $this->setValue('mentionsJSON', json_encode($a));

        $contentMenu = Engine::GetContentDriver()->getContent('box-admin-menu-block');
        $this->setValue('content_menu', $contentMenu->render());

        // включить box-пункты или нет
        $this->setValue('box', true);

        $this->setValue('engine_includes', Engine::GetHTMLHead()->render());
    }

}