<?php
class shop_product_carousel extends Engine_Class {

    /**
     * ShopProduct
     *
     * @return ShopProduct
     */
    private function _getProducts() {
        $x = $this->getValue('products');
        $x->addWhere('showincategory', 1, '=');
        $x->setHidden(0);
        $x->setDeleted(0);
        $x->setUser_view(1);
        $x = Shop::Get()->getShopService()->setProductsDateLifeFilter($x);
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
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencyDefault();

        $showNoImageProducts = Shop::Get()->getSettingsService()->getSettingValue('show-nophoto-products');

        $a = array();
        while ($p = $products->getNext()) {

            if (!$showNoImageProducts && !$p->getImage()) {
                continue;
            }

            $info = $p->makeInfoArray(false, 200, 175, false);
            $pricesArr = RtmService::Get()->getProductPricesArray($p, $currencyDefault);
            $info['productPrice'] = $pricesArr['productPrice'];
            $info['productPriceOld'] = $pricesArr['productPriceOld'];
            $a[] = $info;
        }
        $this->setValue('productsArray', $a);
    }

}