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
class Shop_ExportECatalog {

    public function process($categoryArray, $productsArray) {
        $xml = '';
        $xml .= '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= "<price date=\"".date('Y-m-d H:i:s')."\">";

        $xml .= "<name>".Shop::Get()->getSettingsService()->getSettingValue('shop-name')."</name>";
        $xml .= "<url>".Engine::Get()->getProjectURL()."</url>";

        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
        $xml .= "<currency code='".$currencyDefault->getName()."' rate='".$currencyDefault->getRate()."' />";

        // список категорий
        $categoryArray[] = -1;
        $productsArray[] = -1;
        $categoryArrayOriginal = $categoryArray;

        // достаем категории то товарам
        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setHidden(0);
        $products->addWhereArray($productsArray);
        $products->addWhereQuery("id NOT IN (SELECT productid FROM shopplacecategory WHERE disable=1)");
        while ($x = $products->getNext()) {
            $categoryArray[] = $x->getCategoryid();
        }
        $categoryArray = array_unique($categoryArray);

        $category = Shop::Get()->getShopService()->getCategoryAll();
        $category->addWhereArray($categoryArray);
        $xml .= "<catalog>";
        while ($x = $category->getNext()) {
            $name = $this->_fixUTF8String($x->getName());
            $xml .= '<category id="'.$x->getId().'" parentID="'.$x->getParentid().'">'.$name.'</category>';
        }
        $xml .= "</catalog>";

        // список товаров
        $xml .= "<items>";

        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setHidden(0);
        $products->addWhere('avail', 0, '>');
        // @todo: только дорогие товары
        $priceMin = trim(Shop::Get()->getSettingsService()->getSettingValue('min-price-export-places'));
        if (preg_match('/(\d+)/ius', $priceMin, $r)) {
            $priceMin = $r[1];
        }
        $products->addWhere('price', $priceMin, '>=');
        $products->addWhere('image', '', '!=');
        $products->addWhereQuery(
            "(categoryid IN (".implode(',', $categoryArrayOriginal).") OR id IN (".implode(',', $productsArray)."))"
        );

        while ($x = $products->getNext()) {
            $xmlProduct = '';

            try {
                if ($x->getCategory()->isHidden()) {
                    continue;
                }

                $price = $x->getPriceWithDiscount();
                $price = Shop::Get()->getCurrencyService()->convertCurrency(
                    $price,
                    $x->getCurrency(),
                    $currencyDefault
                );

                $description = $x->getDescription();
                $description = $this->_fixUTF8String($description);

                $name = $x->getName();
                $name = $this->_fixUTF8String($name);

                $url = $x->makeURL();
                $url .= '?utm_source='.$this->_getUTMSource();
                $url .= '&amp;utm_medium=cpc';
                $url .= '&amp;utm_campaign=default';
                $url .= '&amp;utm_term='.urlencode($x->getName());
                $url .= '&amp;utm_content='.$x->getId();

                $image = false;
                if ($x->getImage()) {
                    $image = Engine::Get()->getProjectURL().$x->makeImageThumb(400);
                }
                $categoryID = $x->getCategoryid();

                $xmlProduct .= "<item id='{$x->getId()}'>\n";
                $xmlProduct .= "<name><![CDATA[{$name}]]></name>\n";
                $xmlProduct .= "<price>{$price}</price>\n";
                $xmlProduct .= "<categoryId>{$categoryID}</categoryId>\n";
                try {
                    $brand = $x->getBrand();
                    $xmlProduct .= "<vendor><![CDATA[{$brand->getName()}]]></vendor>\n";
                } catch (Exception $brandEx) {

                }

                $xmlProduct .= "<description><![CDATA[{$description}]]></description>\n";
                $xmlProduct .= "<url>{$url}</url>\n";
                $xmlProduct .= "<image>{$image}</image>\n";
                $xmlProduct .= "<code>{$x->getId()}</code>\n";
                $xmlProduct .= "</item>\n";

                $xml .= $xmlProduct;
            } catch (Exception $e) {

            }
        }

        $xml .= "</items>";

        $xml .= "</price>";

        return $xml;
    }

    private function _fixUTF8String($str) {
        $str = strip_tags($str);
        $str = preg_replace('/([^\d\w\pL\.\-;,_\s\n])/ius', '', $str);
        $str = trim($str);
        return $str;
    }

    protected function _getUTMSource() {
        return 'ecatalog';
    }

}