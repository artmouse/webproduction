<?php

class Order_AdminMenu implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        // добавляем пункты меню
        if (!Shop_ModuleLoader::Get()->isImported('box')
            || Engine::Get()->getConfigFieldSecure('static-shop-menu')
        ) {
            Shop_ModuleLoader::Get()->registerTopMenuItem(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_ords'),
                Engine::GetLinkMaker()->makeURLByContentID('shop-admin-orders'),
                'orders',
                'icon-order'
            );
        }

        // отчеты
        Shop_ModuleLoader::Get()->registerReportMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_matrix_products_customers'),
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-orders-report'),
            'report-productmatrix'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Самые заказываемые товары',
            Engine::GetLinkMaker()->makeURLByContentID('report-topproducts'),
            'report-topproducts'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Отчет по ценам поставщика',
            Engine::GetLinkMaker()->makeURLByContentID('report-priceinsupplier'),
            'report'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Заказанные товары',
            Engine::GetLinkMaker()->makeURLByContentID('report-orderedproducts'),
            'report-topproducts'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Отчет клиентов по заказанному товару',
            Engine::GetLinkMaker()->makeURLByContentID('report-clientonproduct'),
            'report-topproducts'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Карта клиентов по статусам',
            Engine::GetLinkMaker()->makeURLByContentID('report-mapclientonstatus'),
            'report'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_svodniy_otchet'),
            '/admin/shop/report/summary/'
        );

    }

}