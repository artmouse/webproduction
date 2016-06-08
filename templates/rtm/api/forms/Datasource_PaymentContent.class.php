<?php
/**
 * WebProduction Shop (wpshop)
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
        $this->addOption('shop-payment-portmone', 'Portmone.com');
    }

}