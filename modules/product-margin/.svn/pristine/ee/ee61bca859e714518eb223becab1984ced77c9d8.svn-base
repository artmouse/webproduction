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
 * Пересчет цен
 *
 * @author    a.lazarenko
 * @copyright WebProduction
 * @package   Shop
 */

class MarginRule_Processor_PriceTask {
    public function process() {
        // Проверить количество задач на пересчет
        $calculateIssue = new XShopProductPriceTask();
        $calculateIssue->setPdate('0000-00-00 00:00:00');
        $calculateCount = $calculateIssue->getCount();

        while ($calculateCount) {
            $calculateCount--;
            try {
                Shop::Get()->getSupplierService()->processProductPriceTask();
            } catch (Exception $e) {
                LogService::Get()->add($e, 'marginPrice');
            }

        }
    }
}