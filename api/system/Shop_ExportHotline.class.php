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
class Shop_ExportHotline {

    public function process($categoryArray, $productsArray) {
        $xml = '';
        $xml .= '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= "<price>";
        $xml .= '<date>'.date('Y-m-d H:i:s').'</date>';

        $xml .= "<firmName>".Shop::Get()->getSettingsService()->getSettingValue('shop-name')."</firmName>";
        $xml .= "<firmId>".Shop::Get()->getSettingsService()->getSettingValue('shop-hotline-id')."</firmId>";

        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
        $currencyUAH = Shop::Get()->getCurrencyService()->getCurrencyByName('UAH');
        $currencyUSD = Shop::Get()->getCurrencyService()->getCurrencyByName('USD');

        //$xml .= "<rate>".$currencyDefault->getRate()."</rate>";
        $xml .= "<rate></rate>";

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

        $xml .= "<categories>";
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $category->addWhereArray($categoryArray);
        while ($x = $category->getNext()) {
            $name = $this->_fixUTF8String($x->getName());

            $xml .= "<category>";
            $xml .= "<id>{$x->getId()}</id>";
            $xml .= "<parentId>{$x->getParentid()}</parentId>";
            $xml .= "<name>{$name}</name>";
            $xml .= "</category>";
        }
        $xml .= "</categories>";

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
        $products->addWhere('price', $priceMin, '>=');
        // картинка или кроп
        $products->addWhereQuery("(image != '' OR imagecrop != '')");
        $products->addWhereQuery(
            "(categoryid IN (".implode(',', $categoryArrayOriginal).") OR id IN (".implode(',', $productsArray)."))"
        );

        while ($x = $products->getNext()) {
            $xmlProduct = '';

            try {
                if ($x->getCategory()->isHidden()) {
                    continue;
                }

                $url = $x->makeURL();
                $url .= '?utm_source='.$this->_getUTMSource();
                $url .= '&amp;utm_medium=cpc';
                $url .= '&amp;utm_campaign=default';
                $url .= '&amp;utm_term='.urlencode($x->getName());
                $url .= '&amp;utm_content='.$x->getId();

                $price = $x->getPriceWithDiscount();

                $description = $x->getDescription();
                $description = $this->_fixUTF8String($description);

                $name = $x->getName();
                $name = $this->_fixUTF8String($name);

                $xmlProduct .= "<item>";
                $xmlProduct .= "<categoryId>{$x->getCategoryid()}</categoryId>";
                $xmlProduct .= "<code>{$x->getId()}</code>";

                try {
                    $brandName = $x->getBrand()->getName();
                    $brandName = $this->_fixUTF8String($brandName);

                    $xmlProduct .= "<vendor><![CDATA[{$brandName}]]></vendor>";
                } catch (Exception $brandEx) {

                }

                $xmlProduct .= "<name><![CDATA[{$name}]]></name>";
                $xmlProduct .= "<description><![CDATA[{$description}]]></description>";
                $xmlProduct .= "<url>{$url}</url>";
                if ($x->getImage() || $x->getImagecrop()) {
                    $xmlProduct .= "<image>".Engine::Get()->getProjectURL().$x->makeImageThumb(400)."</image>";
                }

                $priceUAH = Shop::Get()->getCurrencyService()->convertCurrency(
                    $price,
                    $x->getCurrency(),
                    $currencyUAH
                );

                $priceUSD = Shop::Get()->getCurrencyService()->convertCurrency(
                    $price,
                    $x->getCurrency(),
                    $currencyUSD
                );

                $xmlProduct .= "<priceRUAH>".$priceUAH."</priceRUAH>"; // розница в грн
                $xmlProduct .= "<priceRUSD>".$priceUSD."</priceRUSD>"; // розница в долларах
                $xmlProduct .= "<priceOUSD></priceOUSD>"; // опт в долларах

                if ($x->getAvail()) {
                    $xmlProduct .= "<stock>есть</stock>";
                } else {
                    $xmlProduct .= "<stock>нет</stock>";
                }

                $xmlProduct .= "<guarantee></guarantee>"; // @todo
                $xmlProduct .= "</item>";

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
        return 'hotline.ua';
    }

}