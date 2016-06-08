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
class ShopSupplier_Processor_UploadProducts {

    public function process() {
        // пересчет наличия по поставщикам и складам
        Shop::Get()->getSupplierService()->updateProductsWithPriceEntity();
    }
}