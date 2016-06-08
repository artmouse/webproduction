<?php
/**
 * OneBox
 * 
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopMarginRuleLink extends XShopMarginRuleLink {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * ShopMarginRuleLink
     * 
     * @return ShopMarginRuleLink
     */
    public function getNext($exception = false) {
        1;
        return parent::getNext($exception);
    }

    /**
     * ShopMarginRuleLink
     * 
     * @return ShopMarginRuleLink
     */
    public static function Get($key) {
        return self::GetObject('ShopMarginRuleLink', $key);
        
    }

    /**
     * Проверка наличия наценки для категории
     * @param $categoryId
     * @return bool|ShopMarginRuleLink
     */
    public function categoryHasMarginrule( $categoryId ) {
        try {
            $category = Shop::Get()->getShopService()->getCategoryByID($categoryId);
            // нужно возвращать все
            // поскольку проверка отсечет правило по бренду или поставщику
            // а дальше может быть правило которое входит
            $links = new ShopMarginRuleLink();
            $links->setObjecttype($category->getClassname());
            $links->setObjectid($category->getId());

            return $links;
        } catch (Exception $e) {
            return false;
        }

    }

}