<?php
/**
 * Крон
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   OneBox
 */
class Shop_CronHourDefault implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        
        // экспорт на прайс-площадки
        // @todo to module
        PricePlaceService::Get()->processExports();

        // пересчет группированых товароы
        ProcessorQueService::Get()->addProcessor('Shop_Processor_UpdateProductGrouped');

        // вытягивание картинок из tmpimageurl
        ProcessorQueService::Get()->addProcessor('Shop_Processor_ImportProductImageFromURLs');

        // автоматическое открытие или закрытие задач если статус closed 0/1
        ProcessorQueService::Get()->addProcessor('Shop_Processor_ProcessStatus');

        // экспорт product, brand, category в XML/JSON
        if (Shop::Get()->getSettingsService()->getSettingValue('product-export-xml-json')) {
            Shop::Get()->getShopService()->exportProducts();
        }
        if (Shop::Get()->getSettingsService()->getSettingValue('brand-export-xml-json')) {
            Shop::Get()->getShopService()->exportBrands();
        }
        if (Shop::Get()->getSettingsService()->getSettingValue('category-export-xml-json')) {
            Shop::Get()->getShopService()->exportCategories();
        }

        //Shop::Get()->getShopService()->updateTypeOrders();
        ProcessorQueService::Get()->addProcessor('Shop_Processor_UpdateTypeOrders');
        
        // перенос лога в основной
        HistoryService::Get()->processHistoryLog();

        // перенос истории просмотра товаров в основной лог
        HistoryService::Get()->processProductView();
    }
}