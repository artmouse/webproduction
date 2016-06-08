<?php
class block_category_top extends Engine_Class {

    public function process() {
        // подкатегории
        $subcategories = Shop::Get()->getShopService()->getCategoryAll();
        $subcategories->setHidden(0);
        $subcategories->setParentid(0);

        $a = array();
        while ($x = $subcategories->getNext()) {
            $childs = Shop::Get()->getShopService()->getCategoriesByParentID($x->getId());
            $childs->setHidden(0);
            $childsArray = array();

            while ($y = $childs->getNext()) {
                $childsArray[] = array(
                'name' => $y->makeName(),
                'url' => $y->makeURL(),
                'productCount' => $y->getProductcount()
                );
            }

            $image = false;

            if ($x->makeImageThumb()) {
                $image = $x->makeImageThumb();
            } else {
                $product = Shop::Get()->getShopService()->getProductsByCategory($x);
                $product->addWhere('image', '', '<>');
                $product->setLimitCount(1);
                if ($w = $product->getNext()){
                    $image = $w->makeImageThumb(200);
                }
            }

            $a[] = array(
            'name' => $x->makeName(),
            'url' => $x->makeURL(),
            'image' => $image,
            'childsArray' => $childsArray,
            'productCount' => $x->getProductcount(),
            );
        }

        $this->setValue('subcategoriesArray', $a);
    }

}