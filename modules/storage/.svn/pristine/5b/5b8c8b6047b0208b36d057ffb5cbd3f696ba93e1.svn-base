<?php
class tpl_storage extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/modules/storage/contents/admin/linkwindow/api2.js');
        PackageLoader::Get()->registerJSFile('/modules/storage/contents/admin/linkwindow/linkwindow.js');
        PackageLoader::Get()->registerJSFile('/modules/storage/contents/admin/ajaxproduct/ajaxproduct.js');
        PackageLoader::Get()->registerJSFile('/modules/storage/contents/admin/ajaxproduct/product_filter_autocomplete.js');

        $this->setValue('urlIncoming', Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-storage-motion-list', 'incoming', 'type'));
        $this->setValue('urlTransfer', Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-storage-motion-list', 'transfer', 'type'));
        $this->setValue('urlSale', Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-storage-motion-list', 'sale', 'type'));
        $this->setValue('urlProduction', Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-storage-motion-list', 'production', 'type'));

        try {
            $user = $this->getUser();

            // передаем все ACL user'a
            $acl = Shop::Get()->getUserService()->getUserACLArray(
            $this->getUser()
            );

            $this->setValue('acl', $acl);
        } catch (Exception $e) {

        }
    }

}