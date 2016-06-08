<?php
class shop_product_list_thumbsgrouped extends Engine_Class {

    public function __construct($contentID) {
        parent::__construct($contentID);
        $this->setValue('showPages', true);
        $this->setValue('showFilters', true);
        $this->setValue('showSort', true);
    }

    public function process() {
        // получение дефолтной валюты
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

        // берем все продукты
        $products = $this->_getProducts();

        // выбираем из них только поле, по которому группируем
        $groupBy = Shop::Get()->getShopService()->getProductsGroup($products);
        $sql = "SELECT `shopproduct`.`".$groupBy."` FROM `shopproduct` WHERE ".$products->makeWhereString();
        // очищаем старый Where
        $products->clearWhere();
        // выбираем продукты first, из shopproductgrouped, используя поле группировки
        $products->addWhereQuery(
            '`id` IN (
                SELECT `productid` FROM `shopproductgrouped` WHERE `first` = "1" AND `groupedfield` IN ('.$sql.')
            )'
        );

        $a = array();

        while ($x = $products->getNext()) {
            try {
                if ($x->isHidden()) {
                    continue;
                }

                $info = $x->makeInfoArray();

                if ($groupBy && $x->getField($groupBy)) {
                    $info['name'] = $x->getField($groupBy);
                }

                $info['orderurl'] = $this->makeURL(array('buy' => $x->getId()));
                $info['discount'] = $x->getDiscount();
                $info['avail'] = $x->getAvail();
                $info['availtext'] = trim($x->getAvailtext());
                $info['canbuy'] = $x->getCanBuy();

                $description = strip_tags(trim($x->getDescriptionshort()));

                /*if ($description) {
                    $description .= "<br/>";
                }
                $description .= $x->makeCharacteristicsString();*/

                //$this->setValue('characteristics', nl2br(htmlspecialchars($x->getCharacteristics())));
                $info['descriptionshort'] = $description;
                $info['share'] = $x->getShare();
                $info['priceold'] = $x->makePriceOld($currencyDefault);
                try {
                    $icon = $x->getIcon();
                    $info['iconImage'] = $icon->makeImage();
                    $info['iconName'] = $icon->makeName();
                } catch (Exception $iconEx) {

                }
                $info['canMakePreorder'] = $x->getPreorderDiscount();
                $info['rating'] = round($x->getRating());
                $info['urlEdit'] = $x->makeURLEdit();
                try {
                    $info['brandName'] = $x->getBrand()->makeName();
                } catch (Exception $e) {

                }

                // прверка картинки
                if ($x->getField($groupBy)) {
                    $grouped = new XShopProductGrouped();
                    $grouped->setCategoryid($x->getCategoryid());
                    $grouped->setGroupedfield($x->getField($groupBy));
                    $grouped = $grouped->getNext();
                    if ($grouped && $grouped->getImage()) {
                        $info['image'] = Shop_ImageProcessor::MakeThumbUniversal(
                            MEDIA_PATH.'/shop/'.$grouped->getImage(),
                            330,
                            225,
                            'prop'
                        );
                    }
                }

                $a[] = $info;
            } catch (Exception $e) {

            }
        }

        $this->setValue('productsArray', $a);
        $this->setValue('productsCount', $products->getCount());
    }

    /**
     * Метод-обертка для типизации переменной
     *
     * @return ShopProduct
     */
    private function _getProducts() {
        return $this->getValue('products');
    }

}