<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Egor Gerasimchuk <milhous@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_ContentFieldImage extends Forms_ContentField {

    public function __construct($keyValue) {
        parent::__construct($keyValue);

        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();
        $keyPrimary = $this->getDataSourceGroup()->getFieldPrimary()->getKey();

        $id = @$cellsArray[$keyPrimary];
        if ($id) {
            try {
                $product = Shop::Get()->getShopService()->getProductByID($id);
                $image = $product->makeImageThumb(200, 200);
                $assigns['productid'] = $id;
                $assigns['image'] = $image;
            } catch (Exception $e) {

            }
        }

        return $this->getContentView()->render($assigns);
    }

}