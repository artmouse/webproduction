<?php
class shop_product_list_subcategory extends Engine_Class {

    public function __construct($contentID) {
        parent::__construct($contentID);

        $this->setValue('showPages', false);
        $this->setValue('showFilters', false);
        $this->setValue('showSort', false);
    }

    public function process() {
        $subcategories = $this->_getSubcategories();

        $subcategoriesArray = array();
        while ($x = $subcategories->getNext()) {
            $childs = Shop::Get()->getShopService()->getCategoriesByParentID($x->getId());
            $childs->setHidden(0);
            $childsArray = array();
            while ($y = $childs->getNext()) {
                $childsArray[] = array(
                'name' => $y->makeName(),
                'productcount' => $y->getProductcount(),
                'url' => $y->makeURL(),
                );
            }

            // Картинка категориия (Подкатегории)
            if ($x->makeImageThumb()) {
                // Если есть картинка, то все ок
                $image = $x->makeImageThumb(200);
            } else {
                // Если нету картинки, то отдаем картинку первого товара, у которого есть картинка.
                $image = false;
                $product = Shop::Get()->getShopService()->getProductsByCategory($x);
                $product->addWhere('image', '', '<>');
                $product->setLimitCount(1);
                if ($w = $product->getNext()) {
                    $image = $w->makeImageThumb(200);
                }
            }

            // Накапливаем массив
            $subcategoriesArray[] = array(
            'name' => $x->makeName(),
            'productcount' => $x->getProductcount(),
            'url' => $x->makeURL(),
            'image' => $image,
            'childsArray' => $childsArray
            );
        }

        $this->setValue('subcategoriesArray', $subcategoriesArray);
    }

    /**
     * Method for typing
     *
     * @return ShopProduct
     */
    private function _getProducts() {
        return $this->getValue('products');
    }

    /**
     * Method for typing
     *
     * @return ShopCategory
     */
    private function _getSubcategories() {
        return $this->getValue('subcategories');
    }

}