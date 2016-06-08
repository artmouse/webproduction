<?php
class shop_product_list_thumbs extends Engine_Class {

    public function __construct($contentID) {
        parent::__construct($contentID);
        $this->setValue('showPages', true);
        $this->setValue('showFilters', true);
        $this->setValue('showSort', true);
    }

    public function process() {
        $products = $this->_getProducts();

        // получение дефолтной валюты
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

        $a = array();

        while ($x = $products->getNext()) {
            try {
                if ($x->isHidden()) {
                    continue;
                }

                $info = $x->makeInfoArray();
                $info['orderurl'] = $this->makeURL(array('buy' => $x->getId()));
                $info['discount'] = $x->getDiscount();
                $info['avail'] = $x->getAvail();
                $info['availtext'] = trim($x->getAvailtext());
                $info['canbuy'] = $x->getCanBuy();

                $description = strip_tags(trim($x->getDescriptionshort()));

                if ($description) {
                    $description .= "<br/>";
                }
                $description .= $x->makeCharacteristicsString();

                $this->setValue('characteristics', nl2br(htmlspecialchars($x->getCharacteristics())));
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

                $a[] = $info;
            } catch (Exception $e) {

            }
        }

        $this->setValue('productsArray', $a);
        $this->setValue('productsCount', $products->getCount());
    }

    /**
     * Получить продукты
     *
     * @return ShopProduct
     */
    private function _getProducts() {
        return $this->getValue('products');
    }

}