<?php

class Storage_AdminMenu implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        $menuArray = array(
            array(
                'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_incoming_products'),
                'url' => Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-incoming'),
                'acl' => 'storage_incoming',
            ),
            /*array(
                'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_orders_transfer'),
                'url' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-storage-order-index', 'transfer', 'type'),
                'acl' => 'storage_transfer',
            ),*/
            array(
                'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_transfer_products'),
                'url' => Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-transfer'),
                'acl' => 'storage_transfer',
            ),
            array(
                'name' => 'Списание со склада',
                'url' => Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-outcoming'),
                'acl' => 'storage_outcoming',
            ),
            array(
                'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_storage_sale_check_out'),
                'url' => Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-sale'),
                'acl' => 'storage_sale',
            ),
            /*array(
                'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_orders_production'),
                'url' => Engine::GetLinkMaker()->makeURLByContentIDParam(
                    'shop-admin-storage-order-index',
                    'production',
                    'type'
                ),
                'acl' => 'storage_production',
            ),*/
            array(
                'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_production_of_products'),
                'url' => Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-production'),
                'acl' => 'storage_production',
            ),
            array(
                'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_passport_of_products'),
                'url' => Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-product-passports'),
                'acl' => 'storage_passports',
            ),
            array(
                'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_storage_balance'),
                'url' => Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-balance'),
                'acl' => 'storage_balance',
            ),
            array(
                'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_balance_employees'),
                'url' => Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-balance-employees'),
                'acl' => 'storage_balance',
            ),
            array(
                'name' => 'Минимальный резерв',
                'url' => Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-report-reserve'),
                'acl' => 'storage_balance',
            ),
            array(
                'name' => 'Переучет',
                'url' => Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-stocktaking'),
                'acl' => 'storage_balance',
            ),
            array(
                'name' => 'Журнал',
                'url' => Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-motion-list'),
                'acl' => 'storage_motionlog',
            ),
            array(
                'name' => 'Печать ценников',
                'url' => Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-pricecode-print'),
                'acl' => 'storage_barcode',
            ),
            array(
                'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_barcode_printing'),
                'url' => Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-barcode-print'),
                'acl' => 'storage_barcode',
            ),
            array(
                'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_barcode_reading'),
                'url' => Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-barcode-read'),
                'acl' => 'storage_barcode',
            )
        );

        // добавляем склады в верхнее меню
        Shop_ModuleLoader::Get()->registerTopMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_inventory_management'),
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-balance'),
           // 'javascript:void(0);', // ибо по другому никак
            'storage',
            'icon-storage',
            $menuArray
        );

        // добавляем склады в меню настроек
        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            'Склады',
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-name'),
            'storage-settings'
        );

        // добавляем паспорта товаров в меню настроек
        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_passport_of_products'),
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-product-passports'),
            'storage-passports'
        );

        // добавляем "отчет о закупках"
        Shop_ModuleLoader::Get()->registerReportMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_storage_report_purchases'),
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-balance-vendors'),
            'storage-balance-vendors'
        );

        // добавляем "отчет об отгрузках"
        Shop_ModuleLoader::Get()->registerReportMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_storage_report_shipments'),
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-balance-sales'),
            'storage-balance-sales'
        );

        // добавляем "отчет по прибыли"
        Shop_ModuleLoader::Get()->registerReportMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_storage_report_profits'),
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-report-sales'),
            'storage-report-sales'
        );

        // добавляем "отчет об изменении баланса"
        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Отчет об изменении баланса на складе',
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-report-motion'),
            'storage-report-motion'
        );

        // добавляем "отчет о минимальном резерве"
        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Минимальный резерв и РРЦ на складах',
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-report-reserve'),
            'storage-balance'
        );

        // добавляем в настройки "отчет о минимальном резерве"
        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            'Минимальный резерв и РРЦ на складах',
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-report-reserve'),
            'storage-balance'
        );
    }

}