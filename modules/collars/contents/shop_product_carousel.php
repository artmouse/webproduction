<?php
class shop_product_carousel extends Engine_Class {

    /**
     * Получитть продукты
     *
     * @return ShopProduct
     */
    private function _getProducts() {
        $x = $this->getValue('products');
        $x->setHidden(0);
        $x->setDeleted(0);
        return $x;
    }

    public function process() {

        $admin = false;
        try {
            if ($this->getUser()->isAdmin()) {
                $admin = true;
            }
        } catch (Exception $e) {

        }

        $products = $this->_getProducts();

        $a = array();
        while ($p = $products->getNext()) {
            if ($p->isHidden()) {
                continue;
            }
            $info = $this->makeInfoArray($p);

            $a[] = $info;
        }

        //print_r($a);
        $this->setValue('productsArray', $a);
    }


    /**
     * Построить информацию о товаре
     *
     * @return array
     */
    public function makeInfoArray(ShopProduct $p) {
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

        $a = array();
        $a['id'] = $p->getId();
        $a['code'] = $p->makeCode();
        $a['name'] = $p->makeName();
        $a['nameQuick'] = str_replace("'", "\'", $p->makeName());
        $a['description'] = $p->getDescription();
        // #60817 если есть кроп, то берем кроп изображение, а не основное
        // необходимо указывать ширину дабы ImageProcessor смог расчитать положение wotemark
        if ($p->getImagecrop()) {
            $a['image'] = Shop_ImageProcessor::MakeThumbUniversal(
                MEDIA_PATH.'/shop/'.$p->getImagecrop(),
                330,
                225,
                'prop'
            );
        } else {
            $a['image'] = $p->makeImageThumb(330, 330, 'prop');
        }
        $a['url'] = $p->makeURL();
        $a['canbuy'] = $p->getCanBuy();
        $a['price'] = $p->makePrice($currencyDefault, true);
        $a['unit'] = $p->getUnit();
        $a['currency'] = $currencyDefault->getSymbol();
        $a['rating'] = $p->makeRating();
        $a['ordered'] = $p->getOrdered();
        $a['avail'] = $p->getAvail();
        $a['availtext'] = $p->getAvailtext();
        $a['model'] = $p->getModel();
        $a['seriesname'] = $p->getSeriesname();
        $a['priceold'] = $p->makePriceOld($currencyDefault);
        try {
            $icon = $p->getIcon();
            $a['iconImage'] = $icon->makeImage();
            $a['iconName'] = $icon->makeName();
        } catch (Exception $iconEx) {

        }
        return $a;
    }
}