<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2015 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Shop_contentFieldSearchProduct
 *
 * @author    Andrey Lazarenko
 * @copyright WebProduction
 * @package   Shop
 */
class Shop_contentFieldSearchProduct extends Forms_ContentField {

    public function __construct($key) {
        parent::__construct($key);

        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $rowIndex;
        $assigns = array();
        $keyPrimary = $this->getDataSourceGroup()->getFieldPrimary()->getKey();

        $id = @$cellsArray['productid'];
        if ($id) {
            try {
                $product = Shop::Get()->getShopService()->getProductByID($id);
                $assigns['productid'] = $product->getId();
                $assigns['name'] = $product->makeName();
                $assigns['url'] = $product->makeURLEdit();
                $assigns['key'] = $keyPrimary;
            } catch (Exception $e) {

            }
        }

        return $this->getContentView()->render($assigns);
    }

}