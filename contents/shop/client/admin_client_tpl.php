<?php
class admin_client_tpl extends Engine_Class {

    public function process() {
        $admin = false;
        try {
            $admin = $this->getUser()->isAdmin();
        } catch (Exception $e) {

        }
        $this->setValue('admin', $admin);

        $this->setValue('page', Engine::Get()->getRequest()->getContentID());

        // Выводить или нет ссылку сраынения товаров.
        $this->setValue('countCompare', Shop::Get()->getCompareService()->getCompareProducts()->getCount());

        // дополнительные табы от модулей
        $moduleTabArray = Shop_ModuleLoader::Get()->getProfileTabArray();
        foreach ($moduleTabArray as $k => $moduleTabInfo) {
            $moduleTabArray[$k]['url'] = Engine::GetLinkMaker()->makeURLByContentID($moduleTabInfo['contentID']);
        }
        $this->setValue('moduleTabArray', $moduleTabArray);
    }

}