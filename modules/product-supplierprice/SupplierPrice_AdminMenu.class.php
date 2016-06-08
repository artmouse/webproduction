<?php

class SupplierPrice_AdminMenu implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_download_the_price_list_provider'),
            '/admin/shop/products/supplier/import/',
            'products-import'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_Ignore_list_supplier_products'),
            '/admin/shop/products/supplier/ignore/',
            'products-import'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_suppliers'),
            '/admin/shop/supplier/',
            'supplier'
        );
    }

}