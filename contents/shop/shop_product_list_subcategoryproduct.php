<?php
class shop_product_list_subcategoryproduct extends Engine_Class {

    public function __construct($contentID) {
        parent::__construct($contentID);
        $this->setValue('showPages', true);
        $this->setValue('showFilters', true);
        $this->setValue('showSort', true);
    }

    public function process() {
        $subcategories = $this->_getSubcategories();

        $subcategoriesArray = array();
        while ($x = $subcategories->getNext()) {
            $categoryProducts = $x->getProducts();
            $categoryProducts->setHidden(0);

            $productArray = array();
            while ($y = $categoryProducts->getNext()) {
                if ($y->isHidden()) {
                    continue;
                }
                $info = $y->makeInfoArray();
                $info['orderurl'] = $this->makeURL(array('buy' => $y->getId()));
                $info['discount'] = $y->getDiscount();
                $info['avail'] = $y->getAvail();
                $info['availtext'] = trim($y->getAvailtext());
                $info['canbuy'] = $y->getCanBuy();
                $info['descriptionshort'] = trim($y->getDescriptionshort());
                $info['share'] = $y->getShare();
                $info['priceold'] = $y->makePriceOld($currencyDefault);
                $info['iconImage'] = $y->makeIcon();

                $productArray[] = $info;
            }

            if ($x->makeImageThumb()) {
                $image = $x->makeImageThumb();
            } else {
                $image = false;
                $product = Shop::Get()->getShopService()->getProductsByCategory($x);
                $product->addWhere('image', '', '<>');
                $product->setLimitCount(1);
                if ($w = $product->getNext()) {
                    $image = $w->makeImageThumb(200);
                }
            }

            $subcategoriesArray[] = array(
            'name' => $x->makeName(),
            'url' => $x->makeURL(),
            'image' => $image,
            'productArray' => $productArray,
            );
        }

        $this->setValue('subcategoryProductArray', $subcategoriesArray);
    }

    /**
     * Получить продукты
     *
     * @return ShopProduct
     */
    private function _getProducts() {
        return $this->getValue('products');
    }

    /**
     * Получить саькатегории
     *
     * @return ShopCategory
     */
    private function _getSubcategories() {
        return $this->getValue('subcategories');
    }

}