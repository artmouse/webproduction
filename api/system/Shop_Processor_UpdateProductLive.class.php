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
 * Обработчик события,  который ообрабатывает время жизни товаров
 *
 * @author    Andrey Lazarenko <a.lazarenko@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Shop_Processor_UpdateProductLive {

    public function process() {
        // пересчет hidden на основе времени жизни товаров
        Shop::Get()->getShopService()->updateProductLive();
    }

}