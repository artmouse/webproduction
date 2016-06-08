<?php

class PriceExportService {


    public function processECatalog($categoryArray, $productsArray) {
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
            $xml .= '<category id="' . $x->getId() . '" parentID="' . $x->getParentid() . '">' . $name . '</category>';
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
                $url .= '?utm_source=' . $this->_getUTMSourceECatalog();
                $url .= '&amp;utm_medium=cpc';
                $url .= '&amp;utm_campaign=default';
                $url .= '&amp;utm_term=' . urlencode($x->getName());
                $url .= '&amp;utm_content=' . $x->getId();

                $image = false;
                if ($x->getImage()) {
                    $image = Engine::Get()->getProjectURL() . $x->makeImageThumb(400);
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



    public function processFreeMarket($categoryArray, $productsArray) {
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
                $url .= '?utm_source='.$this->_getUTMSourceFreemarket();
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



    public function processHotline($categoryArray, $productsArray) {
        $xml = '';
        $xml .= '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= "<price>";
        $xml .= '<date>' . date('Y-m-d H:i:s') . '</date>';

        $xml .= "<firmName>" . Shop::Get()->getSettingsService()->getSettingValue('shop-name') . "</firmName>";
        $xml .= "<firmId>" . Shop::Get()->getSettingsService()->getSettingValue('shop-hotline-id') . "</firmId>";

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
            "(categoryid IN (".implode(',', $categoryArrayOriginal).") OR id IN (" . implode(',', $productsArray) . "))"
        );

        while ($x = $products->getNext()) {
            $xmlProduct = '';

            try {
                if ($x->getCategory()->isHidden()) {
                    continue;
                }

                $url = $x->makeURL();
                $url .= '?utm_source=' . $this->_getUTMSourceHotline();
                $url .= '&amp;utm_medium=cpc';
                $url .= '&amp;utm_campaign=default';
                $url .= '&amp;utm_term=' . urlencode($x->getName());
                $url .= '&amp;utm_content=' . $x->getId();

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
                    $xmlProduct .= "<image>" . Engine::Get()->getProjectURL() . $x->makeImageThumb(400) . "</image>";
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

                $xmlProduct .= "<priceRUAH>" . $priceUAH . "</priceRUAH>"; // розница в грн
                $xmlProduct .= "<priceRUSD>" . $priceUSD . "</priceRUSD>"; // розница в долларах
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


    public function processNadavi($categoryArray, $productsArray) {
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
            $xml .= '<category id="' . $x->getId() . '" parentID="' . $x->getParentid() . '">' . $name . '</category>';
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
            "(categoryid IN (".implode(',', $categoryArrayOriginal).") OR id IN (" . implode(',', $productsArray) . "))"
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
                $url .= '?utm_source=' . $this->_getUTMSourceNadavi();
                $url .= '&amp;utm_medium=cpc';
                $url .= '&amp;utm_campaign=default';
                $url .= '&amp;utm_term=' . urlencode($x->getName());
                $url .= '&amp;utm_content=' . $x->getId();

                $image = false;
                if ($x->getImage()) {
                    $image = Engine::Get()->getProjectURL() . $x->makeImageThumb(400);
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



    public function processPriceUA($categoryArray, $productsArray) {
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
                $url .= '?utm_source='.$this->_getUTMSourcePriceua();
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



    public function processYML($categoryArray, $productsArray) {
        $xml = '';
        $xml .= '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">';
        $xml .= '<yml_catalog date="'.date('Y-m-d H:i:s').'">';
        $xml .= '<shop>';

        $xml .= '
        <name>'.Shop::Get()->getSettingsService()->getSettingValue('shop-name').'</name>
        <company>'.Shop::Get()->getSettingsService()->getSettingValue('shop-company').'</company>
        <url>'.Engine::Get()->getProjectURL().'</url>
        <platform>OneBox</platform>
        <version>1.0</version>
        <agency>WebProduction</agency>
        <email>support@webproduction.com.ua</email>';

        $xml .= '<currencies>';
        $currencies = Shop::Get()->getCurrencyService()->getCurrencyAll();
        while ($x = $currencies->getNext()) {
            $xml .= '<currency id="'.$x->getName().'" rate="'.$x->getRate().'" />';
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
        $products->addWhereQuery("id NOT IN (SELECT productid FROM shopplacecategory WHERE disable=1)");
        while ($x = $products->getNext()) {
            $categoryArray[] = $x->getCategoryid();
        }

        $categoryArray = array_unique($categoryArray);

        $xml .= '<categories>';
        $data = Shop::Get()->getShopService()->getCategoryAll();
        $data->addWhereArray($categoryArray);
        while ($x = $data->getNext()) {
            $xml .= '<category id="'.$x->getId().'" parentId="'.$x->getParentid().'">'.$x->getName().'</category>';
        }
        $xml .= '</categories>';

        // товары
        $xml .= '<offers>';

        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setHidden(0);
        $products->addWhere('avail', 0, '>');
        $products->addWhere('image', '', '!=');
        // @todo: только дорогие товары
        $priceMin = trim(Shop::Get()->getSettingsService()->getSettingValue('min-price-export-places'));
        if (preg_match('/(\d+)/ius', $priceMin, $r)) {
            $priceMin = $r[1];
        }
        $products->addWhere('price', $priceMin, '>=');
        $products->addWhere('price', $priceMin, '>=');
        $products->addWhereQuery(
            "(categoryid IN (".implode(',', $categoryArrayOriginal).") OR id IN (".implode(',', $productsArray)."))"
        );
        $products->addWhere('price', 0, '>');

        while ($x = $products->getNext()) {
            try {
                if ($x->getCategory()->isHidden()) {
                    continue;
                }

                $xmlProduct = '';

                $avaiable = $x->getAvail() ? 'true' : 'false';

                if ($x->getBrandid() && $x->getModel()) {
                    $xmlProduct .= '<offer id="'.$x->getId().'" type="vendor.model" available="'.$avaiable.'">';
                } else {
                    $xmlProduct .= '<offer id="'.$x->getId().'" available="'.$avaiable.'">';
                }

                $url = $x->makeURL();
                $url .= '?utm_source='.$this->_getUTMSourceYML();
                $url .= '&amp;utm_medium=cpc';
                $url .= '&amp;utm_campaign=default';
                $url .= '&amp;utm_term='.urlencode($x->getName());
                $url .= '&amp;utm_content='.$x->getId();

                $xmlProduct .= '<url>'.$url.'</url>';
                $xmlProduct .= '<price>'.$x->getPriceWithDiscount().'</price>';
                $xmlProduct .= '<currencyId>'.$x->getCurrency()->getName().'</currencyId>';
                $xmlProduct .= '<categoryId>'.$x->getCategoryid().'</categoryId>';

                if ($x->getImage()) {
                    $xmlProduct .= '<picture>'.Engine::Get()->getProjectURL().$x->makeImageThumb(400).'</picture>';
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
                        $xmlProduct .= '<vendor><![CDATA['.$brandName.']]></vendor>';

                        $model = $x->getModel();
                        $model = $this->_fixUTF8String($model);
                        $xmlProduct .= '<model><![CDATA['.$model.']]></model>';
                    } catch (Exception $brandEx) {

                    }
                } else {
                    $name = $x->getName();
                    $name = $this->_fixUTF8String($name);
                    $xmlProduct .= '<name><![CDATA['.$name.']]></name>';
                }
                $description = $x->getDescription();
                $description = $this->_fixUTF8String($description);
                $xmlProduct .= '<description><![CDATA['.$description.']]></description>';
                //$xmlProduct .= '<sales_notes>Необходима предоплата.</sales_notes>';
                //$xmlProduct .= '<manufacturer_warranty>true</manufacturer_warranty>';
                //$xmlProduct .= '<barcode>1234567890120</barcode>';

                $filters = Shop::Get()->getShopService()->getProductFilterValues($x);
                while ($objFilter = $filters->getNext()) {
                    try {
                        $filter = Shop::Get()->getShopService()->getProductFilterByID(
                            $objFilter->getFilterid()
                        );

                        $filterName = $filter->getName();
                        $filterValue = $objFilter->getFiltervalue();
                        if (!$filterValue) {
                            continue;
                        }
                        if (is_array($filterValue)) {
                            continue;
                        }

                        $filterName = $this->_fixUTF8String($filterName);
                        $filterValue = $this->_fixUTF8String($filterValue);
                        $xmlProduct .= '<param name="'.$filterName.'">'.$filterValue.'</param>';
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



    public function processPomUA($categoryArray, $productsArray) {
        // количество фильтров
        $filterCount = Engine::Get()->getConfigFieldSecure('filter_count');
        if (!$filterCount) {
            $filterCount = 10;
        }

        $xml = '';
        $xml .= '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">';
        $xml .= '<yml_catalog date="'.date('Y-m-d H:i:s').'">';
        $xml .= '<shop>';

        $xml .= '
        <name>'.Shop::Get()->getSettingsService()->getSettingValue('shop-name').'</name>
        <company>'.Shop::Get()->getSettingsService()->getSettingValue('shop-company').'</company>
        <url>'.Engine::Get()->getProjectURL().'</url>
        <platform>OneBox</platform>
        <version>1.0</version>
        <agency>WebProduction</agency>
        <email>support@webproduction.com.ua</email>';

        $xml .= '<currencies>';
        $currencies = Shop::Get()->getCurrencyService()->getCurrencyAll();
        while ($x = $currencies->getNext()) {
            $xml .= '<currency id="'.$x->getName().'" rate="'.$x->getRate().'" />';
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
        $products->addWhereQuery("id NOT IN (SELECT productid FROM shopplacecategory WHERE disable=1)");
        while ($x = $products->getNext()) {
            $categoryArray[] = $x->getCategoryid();
        }

        $categoryArray = array_unique($categoryArray);

        $xml .= '<categories>';
        $data = Shop::Get()->getShopService()->getCategoryAll();
        $data->addWhereArray($categoryArray);
        while ($x = $data->getNext()) {
            $xml .= '<category id="'.$x->getId().'" parentId="'.$x->getParentid().'">'.$x->getName().'</category>';
        }
        $xml .= '</categories>';

        // товары
        $xml .= '<offers>';

        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setHidden(0);
        $products->addWhere('avail', 0, '>');
        $products->addWhere('image', '', '!=');
        // @todo: только дорогие товары
        $priceMin = trim(Shop::Get()->getSettingsService()->getSettingValue('min-price-export-places'));
        if (preg_match('/(\d+)/ius', $priceMin, $r)) {
            $priceMin = $r[1];
        }
        $products->addWhere('price', $priceMin, '>=');
        $products->addWhere('price', $priceMin, '>=');
        $products->addWhereQuery(
            "(categoryid IN (".implode(',', $categoryArrayOriginal).") OR id IN (".implode(',', $productsArray)."))"
        );
        $products->addWhere('price', 0, '>');

        while ($x = $products->getNext()) {
            try {
                if ($x->getCategory()->isHidden()) {
                    continue;
                }

                $xmlProduct = '';

                $avaiable = $x->getAvail() ? 'true' : 'false';

                if ($x->getBrandid() && $x->getModel()) {
                    $xmlProduct .= '<offer id="'.$x->getId().'" type="vendor.model" available="'.$avaiable.'">';
                } else {
                    $xmlProduct .= '<offer id="'.$x->getId().'" available="'.$avaiable.'">';
                }

                $url = $x->makeURL();
                $url .= '?utm_source='.$this->_getUTMSourcePromua();
                $url .= '&amp;utm_medium=cpc';
                $url .= '&amp;utm_campaign=default';
                $url .= '&amp;utm_term='.urlencode($x->getName());
                $url .= '&amp;utm_content='.$x->getId();

                $xmlProduct .= '<url>'.$url.'</url>';
                $xmlProduct .= '<price>'.$x->getPriceWithDiscount().'</price>';
                $xmlProduct .= '<currencyId>'.$x->getCurrency()->getName().'</currencyId>';
                $xmlProduct .= '<categoryId>'.$x->getCategoryid().'</categoryId>';

                if ($x->getImage()) {
                    $xmlProduct .= '<picture>'.Engine::Get()->getProjectURL().$x->makeImageThumb(400).'</picture>';
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
                        $xmlProduct .= '<vendor><![CDATA['.$brandName.']]></vendor>';

                        $model = $x->getModel();
                        $model = $this->_fixUTF8String($model);
                        $xmlProduct .= '<model><![CDATA['.$model.']]></model>';
                    } catch (Exception $brandEx) {

                    }
                } else {
                    $name = $x->getName();
                    $name = $this->_fixUTF8String($name);
                    $xmlProduct .= '<name><![CDATA['.$name.']]></name>';
                }
                $description = $x->getDescription();
                $description = $this->_fixUTF8String($description);
                $xmlProduct .= '<description><![CDATA['.$description.']]></description>';
                //$xmlProduct .= '<sales_notes>Необходима предоплата.</sales_notes>';
                //$xmlProduct .= '<manufacturer_warranty>true</manufacturer_warranty>';
                //$xmlProduct .= '<barcode>1234567890120</barcode>';

                for ($j = 1; $j <= $filterCount; $j++) {
                    try {
                        $filter = Shop::Get()->getShopService()->getProductFilterByID(
                            $x->getField('filter'.$j.'id')
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
                        $xmlProduct .= '<param name="'.$filterName.'">'.$filterValue.'</param>';
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

    private function _getUTMSourceECatalog() {
        return 'ecatalog';
    }

    private function _getUTMSourceFreemarket() {
        return 'freemarket';
    }

    private function _getUTMSourceYML() {
        return 'yandex.market';
    }

    private function _getUTMSourceNadavi() {
        return 'nadavi.ua';
    }

    private function _getUTMSourceHotline() {
        return 'hotline.ua';
    }

    private function _getUTMSourcePriceua() {
        return 'price.ua';
    }

    private function _getUTMSourcePromua() {
        return 'prom.ua';
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return PriceExportService
     */
    public static function Get() {
        if (!self::$_Instance) {
            $classname = self::$_Classname;
            if ($classname) {
                self::$_Instance = new $classname();
            } else {
                self::$_Instance = new self();
            }
        }
        return self::$_Instance;
    }

    /**
     * Задать класс сервиса.
     * override-метод.
     *
     * @param string $classname
     */
    public static function Set($classname) {
        self::$_Classname = $classname;
        self::$_Instance = null;
    }

    /**
     * Подменяемый объект сервиса
     *
     * @var PriceExportService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}