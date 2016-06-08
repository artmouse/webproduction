<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_ContentFieldToBasket extends Forms_ContentField {

    public function __construct($keyValue, $type) {
        parent::__construct($keyValue);

        $this->_type = $type;

        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();
        $key = $this->getKey();
        $keyPrimary = $this->getDataSourceGroup()->getFieldPrimary()->getKey();
        // $assigns['key'] = $key;
        // $assigns['value'] = @$cellsArray[$key];
        // $assigns['valueExists'] = (@$cellsArray[$key] !== false);

        $assigns['url'] = Engine::GetLinkMaker()->makeURLByContentIDParams(
        'shop-admin-orders-addproduct',
        array(
        'id' => @$cellsArray[$keyPrimary],
        'type' => $this->_type,
        ));

        $this->getContentView()->setTranslateArray(
        Shop::Get()->getTranslateService()->getTranslateArray()
        );

        return $this->getContentView()->render($assigns);
    }

    private $_type = '';

}