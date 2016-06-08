<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * Пересчет наличия у поставщиков
 *
 * @author    a.lazarenko
 * @copyright WebProduction
 * @package   Shop
 */
class ShopSupplier_Processor_ReadPrice {
    public function process() {
        // количество записей требующих обработки
        
        $x =  new XShopPriceSupplierImport();
        $x->filterPdate('0000-00-00 00:00:00');
        $count = $x->getCount();
        while ($count) {
            echo "import price {$count}";
            $count--;
            try {
                Shop::Get()->getSupplierService()->importSupplierPrice();
            } catch (Exception $e) {
                LogService::Get()->add($e, 'supplierPriceImport');
            }

        }

    }
}