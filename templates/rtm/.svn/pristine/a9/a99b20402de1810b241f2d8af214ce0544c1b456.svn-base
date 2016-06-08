<?php
class Shop_ExportYML {

    public function process($categoryArray, $productsArray) {
        // количество фильтров
        $filterCount = Engine::Get()->getConfigFieldSecure('filter_count');
        if (!$filterCount) {
            $filterCount = 10;
        }

        $xml = '';
        $xml .= '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">';
        $xml .= '<yml_catalog date="' . date('Y-m-d H:i:s') . '">';
        $xml .= '<shop>';

        $xml .= '
        <name>' . Shop::Get()->getSettingsService()->getSettingValue('shop-name') . '</name>
        <company>' . Shop::Get()->getSettingsService()->getSettingValue('shop-company') . '</company>
        <url>' . Engine::Get()->getProjectURL() . '</url>
        <platform>WebProduction Shop</platform>
        <version>1.0</version>
        <agency>WebProduction</agency>
        <email>support@webproduction.com.ua</email>';

        $xml .= '<currencies>';
        $currencies = Shop::Get()->getCurrencyService()->getCurrencyAll();
        while ($x = $currencies->getNext()) {
            $xml .= '<currency id="' . $x->getName() . '" rate="' . $x->getRate() . '" />';
        }
        $xml .= '</currencies>';

        // категории
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

        $xml .= '<categories>';
        $data = Shop::Get()->getShopService()->getCategoryAll();
        $data->addWhereArray($categoryArray);
        while ($x = $data->getNext()) {
            $xml .= '<category id="' . $x->getId() . '" parentId="' . $x->getParentid() . '">' . $x->getName() .
            '</category>';
        }
        $xml .= '</categories>';

        // товары
        $xml .= '<offers>';

        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setHidden(0);
        $products->setAvail(1);
        $products->addWhere('image', '', '!=');
        $products->addWhereQuery(
            "(categoryid IN (" . implode(',', $categoryArrayOriginal) . ") OR id IN (" . implode(',', $productsArray) .
            "))"
        );
        $products->addWhere('price', 0, '>');

        while ($x = $products->getNext()) {
            try {
                $xmlProduct = '';

                $avaiable = $x->getAvail() ? 'true' : 'false';

                if ($x->getBrandid() && $x->getModel()) {
                    $xmlProduct .= '<offer id="' . $x->getId() . '" type="vendor.model" available="' . $avaiable . '">';
                } else {
                    $xmlProduct .= '<offer id="' . $x->getId() . '" available="' . $avaiable . '">';
                }

                $xmlProduct .= '<url>' . $x->makeURL() . '</url>';
                $xmlProduct .= '<price>' . $x->getPriceWithDiscount() . '</price>';
                $xmlProduct .= '<currencyId>' . $x->getCurrency()->getName() . '</currencyId>';
                $xmlProduct .= '<categoryId>' . $x->getCategoryid() . '</categoryId>';

                if ($x->getImage()) {
                    $xmlProduct .= '<picture>' . Engine::Get()->getProjectURL() . $x->makeImageThumb(400) .
                    '</picture>';
                }

                //$xmlProduct .= '<store>true</store>'; // @todo
                //$xmlProduct .= '<pickup>true</pickup>'; // @todo
                $xmlProduct .= '<delivery>true</delivery>'; // @todo
                //$xmlProduct .= '<local_delivery_cost>300</local_delivery_cost>';
                //$xmlProduct .= '<typePrefix>Принтер</typePrefix>';
                if ($x->getBrandid() && $x->getModel()) {
                    try {
                        $brandName = $x->getBrand()->getName();
                        $brandName = $this->_fixUTF8String($brandName);
                        $xmlProduct .= '<vendor><![CDATA[' . $brandName . ']]></vendor>';
                        $model = $x->getModel();
                        $model = $this->_fixUTF8String($model);
                        $xmlProduct .= '<model><![CDATA[' . $model . ']]></model>';
                    } catch (Exception $brandEx) {

                    }
                } else {
                    $name = $x->getName();
                    $name = $this->_fixUTF8String($name);
                    $xmlProduct .= '<name><![CDATA[' . $name . ']]></name>';
                }
                $description = $x->getDescriptionshort();
                $description = str_replace('|', '; ', trim(strip_tags($description)));
                $description = str_replace(';;', '; ', trim(strip_tags($description)));
                $xmlProduct .= '<description><![CDATA[' . $description . ']]></description>';
                //$xmlProduct .= '<sales_notes>Необходима предоплата.</sales_notes>';
                //$xmlProduct .= '<manufacturer_warranty>true</manufacturer_warranty>';
                //$xmlProduct .= '<barcode>1234567890120</barcode>';

                for ($j = 1; $j <= $filterCount; $j++) {
                    try {
                        $filter = Shop::Get()->getShopService()->getProductFilterByID(
                            $x->getField('filter' . $j . 'id')
                        );

                        $filterName = $filter->getName();
                        $filterValue = $x->getFilterValue($filter);
                        if (!$filterValue) {
                            continue;
                        }
                        if (is_array($filterValue)) {
                            continue;
                        }

                        $filterName = $this->_fixUTF8String($filterName);
                        $filterValue = $this->_fixUTF8String($filterValue);
                        $xmlProduct .= '<param name="' . $filterName . '">' . $filterValue . '</param>';
                    } catch (Exception $filterEx) {

                    }
                }

                $xmlProduct .= '</offer>';

                $xml .= $xmlProduct;
            } catch (Exception $e) {

            }
        }

        $xml .= '</offers>';

        $xml .= '</shop>';
        $xml .= '</yml_catalog>';

        return $xml;
    }

    private function _fixUTF8String($str) {
        $str = strip_tags($str);
        $str = preg_replace('/([^\d\w\pL\.\-;,_\s\n])/ius', '', $str);
        $str = trim($str);
        return $str;
    }

}