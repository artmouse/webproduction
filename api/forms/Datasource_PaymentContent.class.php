<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_PaymentContent extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false) {
        parent::__construct($optionsArray);

        $this->addOption('shop-payment-interkassa', 'InterKassa.com');
        $this->addOption('shop-payment-liqpay', 'LiqPay.com');
        if (Shop_ModuleLoader::Get()->isImported('paypal')) {
            $this->addOption('shop-payment-paypal', 'PayPal.com');
        }
        if (Shop_ModuleLoader::Get()->isImported('payza')) {
            $this->addOption('shop-payment-payza', 'Payza.com');
        }
    }

}