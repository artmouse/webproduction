<?php
class Shop_ExportECatalog {

    public function process($categoryArray, $productsArray) {
        $xml = '';
        $xml .= '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= "<price date=\"" . date('Y-m-d H:i:s') . "\">";

        $xml .= "<name>" . Shop::Get()->getSettingsService()->getSettingValue('shop-name') . "</name>";
        $xml .= "<url>" . Engine::Get()->getProjectURL() . "</url>";

        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
        $xml .= "<currency code='" . $currencyDefault->getName() . "' rate='" . $currencyDefault->getRate() . "' />";

        // список категорий
        $categoryArray[] = -1;
        $productsArray[] = -1;
        $categoryArrayOriginal = $categoryArray;

        // достаем категории то товарам
        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setHidden(0);
        $products->addWhereArray($productsArray);
        while ($x = $products->getNext()) {
            $categoryArray[] = $x->getCategoryid();
        }
        $categoryArray = array_unique($categoryArray);

        $category = Shop::Get()->getShopService()->getCategoryAll();
        $category->addWhereArray($categoryArray);
        $xml .= "<catalog>";
        while ($x = $category->getNext()) {
            $name = $this->_fixUTF8String($x->getName());
            $xml .= '<category id="' . $x->getId() . '" parentID="' . $x->getParentid() . '">' . $name . '</category>';
        }
        $xml .= "</catalog>";

        // список товаров
        $xml .= "<items>";

        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setHidden(0);
        $products->setAvail(1);
        $products->addWhere('image', '', '!=');
        $products->addWhereQuery(
            "(categoryid IN (" . implode(',', $categoryArrayOriginal) . ") OR id IN (" . implode(',', $productsArray) .
            "))"
        );

        while ($x = $products->getNext()) {
            $xmlProduct = '';

            try {
                $price = $x->getPriceWithDiscount();
                $price = Shop::Get()->getCurrencyService()->convertCurrency(
                    $price,
                    $x->getCurrency(),
                    $currencyDefault
                );

                $description = $x->getDescriptionshort();
                $description = str_replace('|', '; ', trim(strip_tags($description)));
                $description = str_replace(';;', '; ', trim(strip_tags($description)));
                $description = $this->_fixUTF8String($description);

                $name = $x->getName();
                $name = $this->_fixUTF8String($name);

                $url = $x->makeURL();
                $image = false;
                if ($x->getImage()) {
                    $image = Engine::Get()->getProjectURL() . $x->makeImageThumb(400);
                }
                $categoryID = $x->getCategoryid();

                $xmlProduct .= "<item id='{$x->getId()}'>";
                $xmlProduct .= "<name><![CDATA[{$name}]]></name>";
                $xmlProduct .= "<price>{$price}</price>";
                $xmlProduct .= "<categoryId>{$categoryID}</categoryId>";
                try {
                    $brand = $x->getBrand();
                    $xmlProduct .= "<vendor><![CDATA[{$brand->getName()}]]></vendor>";
                } catch (Exception $brandEx) {

                }

                $xmlProduct .= "<description><![CDATA[{$description}]]></description>";
                $xmlProduct .= "<url>{$url}</url>";
                $xmlProduct .= "<image>{$image}</image>";
                $xmlProduct .= "<code>{$x->getId()}</code>";
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

}