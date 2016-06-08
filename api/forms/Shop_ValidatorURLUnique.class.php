<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Oleksii Golub <avator@webproduction.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Shop_ValidatorURLUnique extends Forms_AValidator {

    public function validate($data) {
        if (empty($data)) {
            return true;
        }
        /*$p = new XShopProduct();
        $p->setUrl($data);
        if(!$p->select()){
            $b = new XShopBrand();
            $b->setUrl($data);
            if(!$b->select()){
                $c = new XShopCategory();
                $c->setUrl($data);
                if(!$c->select()){
                    $t = new XShopTextPage();
                    $t->setUrl($data);
                    if(!$t->select()){
                        return $data;
                    }
                }
            }
        }*/
        return true;
    }
}