<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Формирование файла для выгрузки на прайс-площадку
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Shop_ExportPriceUA extends Shop_ExportECatalog {

    protected function _getUTMSource() {
        return 'price.ua';
    }

}