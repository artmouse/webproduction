<?php
/**
 * Shop_CronImportProductsXML
 *
 * @author Andrii Andriiets <max@webproduction.ua>
 *
 * @copyright WebProduction
 *
 * @package OneClick
 */
class Shop_CronImportProductsXML implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        set_time_limit(0);
        ini_set('pcre.backtrack_limit', 300000);
        require(dirname(__FILE__) . '/../../../../packages/Engine/include.2.6.php');
        Engine::Get()->enableErrorReporting();

        $pidFile = __FILE__ . '.pid';
        if (file_exists($pidFile)) {
            print "\n\nProcess already running...\n\n";
            exit();
        }
        file_put_contents($pidFile, date('Y-m-d H:i:s'), LOCK_EX);

        $this->_importTaskXML();

        unlink($pidFile);

    }

    private function _importTaskXML() {
        // выполняем импорт
        try {
            $taskExist = false;
            $task = new XRtmImport();
            $task->setImportimages(0);
            $task->setPdate('0000-00-00 00:00:00');
            $task = $task->getNext();
            if (!$task) {
                // смотрим есть ли автоматически заброшенный файл
                $fileName = PackageLoader::Get()->getProjectPath() .
                'templates/rtm/media/import_xml/daily_price1c.xml';
                if (!file_exists($fileName)) {
                    echo "no task\n";
                    return;
                }

            } else {
                $taskExist = true;
                $fileName = PackageLoader::Get()->getProjectPath() . 'templates/rtm/media/import_xml/' .
                $task->getFile();
            }
        } catch (Exception $ee) {
            return;
        }

        echo "\n\nStart\n\n";

        $xml = FS_FileXML::Open($fileName)->contentParse();

        $defaultCurrency = Shop::Get()->getCurrencyService()->getCurrencySystem();

        try {
            $filterCount = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filterCount = 10;
        }

        if (!$filterCount) {
            $filterCount = 10;
        }
        $products = Shop::Get()->getShopService()->getProductsAll();
        while ($x = $products->getNext()) {
            for ($index = 1; $index < $filterCount; $index++) {
                $x->setField('filter' . $index . 'id', 0);
                $x->setField('filter' . $index . 'actual', 0);
                $x->setField('filter' . $index . 'markup', 0);
                $x->setField('filter' . $index . 'option', 0);
                $x->setField('filter' . $index . 'use', 0);
                $x->setField('filter' . $index . 'value', 0);
            }
            $x->setSync(1);
            $x->update();
        }

        foreach ($xml->Магазин[0]->Объект as $izdelie) {

            $avail = 1;

            foreach ($izdelie->attributes() as $k => $v) {
                $v = trim($v);
                switch ($k) {
                    case 'ТипИзделия' :
                        $type = $v;
                        break;
                    case 'Артикул' :
                        $code1c = $v;
                        break;
                    case 'Металл' :
                        $metal = $v;
                        break;
                    case 'Остаток' :
                        $avail = intval($v);
                        break;
                    case 'Мастер' :
                        $master = $v;
                        break;
                    case 'ЦенаПродажиСоСкидкой' :
                        $priceProduct = str_replace(',', '.', $v);
                        break;
                    case 'ЦенаПродажиДляПроданногоИзделияСоСкидкой' :
                        $priceProductNotAvail = str_replace(',', '.', $v);
                        break;
                    case 'ЦенаЗаРаботуСоСкидкой' :
                        $price = str_replace(',', '.', $v);
                        break;
                    case 'ЦенаЗаРаботуСоСкидкойДляПроданногоИзделия' :
                        $priceNotAvail = str_replace(',', '.', $v);
                        break;
                    case 'ЦенаПродажи' :
                        $priceProductOld = str_replace(',', '.', $v);
                        break;
                    case 'ЦенаПродажиДляПроданногоИзделия' :
                        $priceProductOldNotAvail = str_replace(',', '.', $v);
                        break;
                    case 'ЦенаЗаРаботу' :
                        $priceOld = str_replace(',', '.', $v);
                        break;
                    case 'ЦенаЗаРаботуДляПроданногоИзделия' :
                        $priceOldNotAvail = str_replace(',', '.', $v);
                        break;
                    case 'Вес' :
                        $vesIzdeliya = str_replace(',', '.', $v);
                        break;
                    case 'Размер' :
                        $razmer = str_replace(',', '.', $v);
                        break;
                    case 'ИнвентарныйНомер' :
                        $inventarniyNomer = $v;
                        break;
                    case 'ВесСУгаром' :
                        $vesSugarom = str_replace(',', '.', $v);
                        break;
                    case 'БазовыйВес' :
                        $vesBase = str_replace(',', '.', $v);
                        break;
                    case 'Субартикул' :
                        $subarticul = $v;
                        break;
                    /*case 'Фото' :
                        $techImage = $v;
                        break;*/
                }
            }

            // ищем в каталоге техническое фото
            $techImage = '';

            if ($code1c) {
                $techImage = $this->_getTechImage($xml, $code1c);
            }

            $vstavkaArr = array();
            $vstavkaAll = array();
            if (isset($izdelie->ТаблицаВставки)) {
                foreach ($izdelie->ТаблицаВставки[0]->СтрокаВставки as $vstavka) {
                    foreach ($vstavka->attributes() as $k => $v) {
                        $v = trim($v);
                        switch ($k) {
                            case 'Вес' :
                                $vstavkaArr['ves'] = str_replace(',', '.', $v);
                                break;
                            case 'Количество' :
                                $vstavkaArr['kolichestvo'] = $v;
                                break;
                            case 'Цвет' :
                                $vstavkaArr['tsvet'] = $v;
                                break;
                            case 'Размер' :
                                $vstavkaArr['razmer'] = str_replace(',', '.', $v);
                                break;
                            case 'Форма' :
                                $vstavkaArr['forma'] = $v;
                                break;
                            case 'Камень' :
                                $vstavkaArr['kamen'] = $v;
                                break;
                        }
                    }
                    $vstavkaAll[] = $vstavkaArr;
                }
            }

            $vidIzdeliya = array();
            if (isset($izdelie->ТаблицаВидИзделия)) {
                foreach ($izdelie->ТаблицаВидИзделия[0]->СтрокаВид as $vid) {
                    foreach ($vid->attributes() as $k => $v) {
                        if ($k == 'ВидИзделия') {
                            $vidIzdeliya[] = trim($v);
                        }
                    }
                }
            }

            $code1c = trim($code1c);

            $type = trim($type);

            $price = trim($price) * 1;

            $priceProduct = trim($priceProduct) * 1;

            $priceOld = trim($priceOld) * 1;

            $priceProductOld = trim($priceProductOld) * 1;

            $priceNotAvail = trim($priceNotAvail) * 1;

            $priceProductNotAvail = trim($priceProductNotAvail) * 1;

            $priceOldNotAvail = trim($priceOldNotAvail) * 1;

            $priceProductOldNotAvail = trim($priceProductOldNotAvail) * 1;

            $categoryID = $this->_getCategoryIDByType($type);

            $masterID = $this->_getMasterID($master);


            try {
                $product = Shop::Get()->getShopService()->getObjectByField(
                    'inventarnumber', $inventarniyNomer, 'ShopProduct'
                );
                // $product = Shop::Get()->getShopService()->getProductByCode1c($code1c);
            } catch (Exception $e) {
                $product = new ShopProduct();
                $product->setInventarnumber($inventarniyNomer);
                try {
                    $brand = Shop::Get()->getShopService()->getBrandByName('РТМ');
                    $product->setBrandid($brand->getId());
                } catch (Exception $e) {

                }
                $product->insert();
            }
            $product->setSubarticul($subarticul);

            $product->setCode1c($code1c);

            $product->setInventarnumber($inventarniyNomer);

            $product->setSync(0);

            $product->setAvail($avail);

            if ($avail > 0) {
                $product->setPrice($price);
                $product->setPrice_product($priceProduct);
                $product->setPriceold($priceOld);
                $product->setPrice_product_old($priceProductOld);
            } else {
                $product->setPrice($priceNotAvail);
                $product->setPrice_product($priceProductNotAvail);
                $product->setPriceold($priceOldNotAvail);
                $product->setPrice_product_old($priceProductOldNotAvail);
            }

            $product->setJewelerid($masterID);

            $product->setWeight($vesIzdeliya);

            $product->setBaseweight($vesBase);

            $product->setTech_image($techImage);

            $description = '';

            if ($code1c) {
                $description = "<span class='artikul'>Артикул: {$code1c}</span>|";
            }

            if ($metal) {
                $description .= "Металл: {$metal}&deg;|";
            }

            if ($vesBase) {
                $description .= "Средний вес плетения: {$vesBase}г|";
            }

            if ($vesIzdeliya) {
                $description .= "Вес изделия: {$vesIzdeliya}г|";
            }

            $product->setSize($razmer);

            $this->_setFilter($product, 'Металл', $metal, $filterCount);

            $this->_setFilter($product, 'Вес изделия', $vesIzdeliya, $filterCount);

            $this->_setFilter($product, 'Размер', $razmer, $filterCount, 1, 0, 0);

            $product->setExchangeweight(filter_var($metal, FILTER_SANITIZE_NUMBER_INT) . ' ' . $vesSugarom);

            $this->_setFilter($product, 'Вес золота для обмена', $vesSugarom, $filterCount, 0, 1, 0);

            $tipIzdeliya = false;
            if (!empty($vstavkaAll)) {
                $vstavkaString = '';
                foreach ($vstavkaAll as $vstavkaArr) {
                    $this->_setFilter(
                        $product, 'Цвет камня', $this->_getTrueColor($vstavkaArr['tsvet']), $filterCount, 1, 1, 0, false
                    );

                    $kamebFilterValue =
                    "{$vstavkaArr['kamen']}/{$vstavkaArr['razmer']}/{$vstavkaArr['forma']}/{$vstavkaArr['ves']}";

                    $vstavkaString .= $kamebFilterValue . ', ';

                    $this->_setFilter(
                        $product, 'Камень/Размер/Форма/Вес', $kamebFilterValue, $filterCount, 0, 1, 0, false
                    );

                    if ($vstavkaArr['kamen'] == 'Жемчуг') {
                        $this->_setFilter($product, 'Тип изделия', 'С жемчугом', $filterCount, 1, 0, 0, false);
                    } else {
                        $this->_setFilter($product, 'Тип изделия', 'С камнями', $filterCount, 1, 0, 0, false);
                    }
                    $tipIzdeliya = true;
                }

                $product->setVstavka(trim($vstavkaString, ', '));

            }
            if (!$tipIzdeliya) {
                $this->_setFilter($product, 'Тип изделия', 'Без камней', $filterCount, 1, 0, 0, false);
            }

            if (!empty($vidIzdeliya)) {
                foreach ($vidIzdeliya as $vid) {
                    $this->_setFilter($product, 'Вид изделия', $vid, $filterCount, 1, 0, 0, false);
                }
            }

            if ($type) {
                $product->setName($type);
                if ($categoryID) {
                    $product->setCategoryid($categoryID);
                    Shop::Get()->getShopService()->buildProductCategories($product);
                }
            }

            if (!$product->getCurrencyid()) {
                try {
                    $product->setCurrencyid($defaultCurrency->getId());
                } catch (Exception $e) {

                }
            }

            if (!empty($description)) {
                $product->setDescriptionshort($description);
            }

            $product->setHidden(0);
            $product->setDeleted(0);

            $product->update();

            print 'Product ' . $product->getCode1c() . " has been proccessed \n\n";

        }

        if ($taskExist) {
            $task->setPdate(DateTime_Object::Now());
            $task->update();
        }

        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setSync(1);
        while ($x = $products->getNext()) {
            $x->setDeleted(1);
            $x->update();
        }

        unlink($fileName);

        $procesedProductIdArr = array();
        $procesedProductSubarticulArr = array();

        // Скрываем товары с одинаковым размером и большим весом.
        try {
            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->setHidden(0);
            $products->setDeleted(0);

            while ($product = $products->getNext()) {

                if (in_array($product->getId(), $procesedProductIdArr)) {
                    continue;
                }

                $optionProducts = new ShopProduct();
                $optionProducts->setSubarticul($product->getSubarticul());
                $optionProducts->setOrder('`weight`+0', 'ASC'); // +0 - костыль чтобы сортировало как число
                $optionProducts->setCategoryid($product->getCategoryid());
                $optionProducts->setSize($product->getSize());
                $optionProducts->setHidden(0);
                $optionProducts->setDeleted(0);

                $first = true;
                while ($x = $optionProducts->getNext()) {
                    $procesedProductIdArr[] = $x->getId();

                    if (!$first) {
                        $x->setHidden(1);
                        $x->update();
                    } else {
                        $first = false;
                    }

                }

                if (in_array($product->getSubarticul(), $procesedProductSubarticulArr)) {
                    continue;
                }

                $optionProducts = new ShopProduct();
                $optionProducts->setSubarticul($product->getSubarticul());
                $optionProducts->setCategoryid($product->getCategoryid());
                $optionProducts->setHidden(0);
                $optionProducts->setDeleted(0);
                $optionProducts->setOrder('weight', 'ASC');

                $first = true;
                while ($x = $optionProducts->getNext()) {
                    if (!$first) {
                        $x->setShowincategory(0);
                        $x->update();
                    } else {
                        $x->setShowincategory(1);
                        $x->update();
                        $procesedProductSubarticulArr[] = $x->getSubarticul();
                        $first = false;
                    }

                }

            }

        } catch (Exception $e) {

        }

    }

    /**
     * Переводим название цвета в нижний регистр и приводим к набору стандартных цветов.
     *
     * @param $color
     *
     * @return string
     */
    private function _getTrueColor($color) {
        trim($color);
        $color = mb_strtolower($color);
        switch ($color) {
            case '101' :
                $color = 'белый';
                break;
            case '102' :
                $color = 'голубой';
                break;
            case '103' :
                $color = 'желтый';
                break;
            case '104' :
                $color = 'зеленый';
                break;
            case '105' :
                $color = 'коричневый';
                break;
            case '106' :
                $color = 'красный';
                break;
            case '107' :
                $color = 'розовый';
                break;
            case '108' :
                $color = 'оранжевый';
                break;
            case '109' :
                $color = 'серый';
                break;
            case '110' :
                $color = 'синий';
                break;
            case '111' :
                $color = 'фиолетовый';
                break;
            case '112' :
                $color = 'черный';
                break;
        }
        return $color;
    }

    /**
     * Добавляем значение фильтра по имени. Если фильтра нет, он будет создан.
     *
     * @param ShopProduct $product
     * @param $filterName
     * @param $filterValue
     * @param $filterCount
     * @param int $use
     * @param int $actual
     * @param int $option
     * @param bool $replaceFilter
     */
    private function _setFilter(
        ShopProduct $product,
        $filterName,
        $filterValue,
        $filterCount,
        $use = 1,
        $actual = 1,
        $option = 0,
        $replaceFilter = true
    ) {
        try {
            try {
                $filter = $this->_getObjectByName($filterName, 'ShopProductFilter');
            } catch (Exception $e) {
                $filter = new ShopProductFilter();
                $filter->setName($filterName);
                $filter->setType('checkbox');
                if (!$filter->select()) {
                    $filter->insert();
                }
            }

            for ($index = 1; $index < $filterCount; $index++) {
                $filterId = $product->getField('filter' . $index . 'id');
                if (!empty($filterValue)) {
                    if ($filterId == 0 || $filterId == $filter->getId() && $replaceFilter) {
                        $product->setField('filter' . $index . 'id', $filter->getId());
                        $product->setField('filter' . $index . 'value', $filterValue);
                        $product->setField('filter' . $index . 'use', $use);
                        $product->setField('filter' . $index . 'actual', $actual);
                        $product->setField('filter' . $index . 'option', $option);
                        $product->update();
                        return;
                    } elseif ($filterId == $filter->getId() &&
                        $filterValue == $product->getField('filter' . $index . 'value')
                    ) {
                        return;
                    }
                } else {
                    if ($filterId == $filter->getId()) {
                        $product->setField('filter' . $index . 'id', 0);
                        $product->setField('filter' . $index . 'value', '');
                        $product->setField('filter' . $index . 'use', 0);
                        $product->setField('filter' . $index . 'actual', 0);
                        $product->setField('filter' . $index . 'option', 0);
                        $product->update();
                        return;
                    }
                }

            }


        } catch (Exception $e) {

        }
    }

    /**
     * GetCategoryIDByType
     *
     * @param $type
     *
     * @return int
     */
    private function _getCategoryIDByType($type) {
        $categoryArray = array(
            'Кольц' => 'Кольца', 'Обруч' => 'Кольца', 'Перст' => 'Кольца',
            'Браслет' => 'Браслеты',
            'Кулон' => 'Кулоны',
            'Ладанк' => 'Крестики, ладанки', 'Крест' => 'Крестики, ладанки',
            'Серьг' => 'Серьги',
            'Цеп' => 'Цепи'
        );
        $categoryID = 0;
        foreach ($categoryArray as $key => $name) {

            if (strpos($type, $key) !== false) {
                try {
                    $category = $this->_getObjectByName($name, 'ShopCategory');
                    $categoryID = $category->getId();
                } catch (Exception $e) {

                }
            }
        }

        return $categoryID;
    }

    /**
     * GetMasterID
     *
     * @param $name
     *
     * @return int
     */
    private function _getMasterID($name) {
        $name = trim($name);
        if (empty($name)) {
            return 0;
        }
        $master = new XJeweler();
        $master->setName($name);
        if (!$master->select()) {
            $master->insert();
        }
        return $master->getId();
    }

    /**
     * GetObjectByName
     *
     * @param $name
     * @param $object
     *
     * @return object
     */
    private function _getObjectByName($name, $object) {
        $name = trim($name);
        return Shop::Get()->getShopService()->getObjectByField('name', $name, $object);
    }

    private function _getTechImage(SimpleXMLElement $xml, $code1c) {
        $y = '';
        try {
            $x = $xml->xpath('Каталог/Объект[@Артикул="' . $code1c . '"]');
            if (isset($x[0])) {
                $y = $x[0]->attributes()->{'Фото'};
            }
        } catch (Exception $e) {

        }

        return $y;
    }

}