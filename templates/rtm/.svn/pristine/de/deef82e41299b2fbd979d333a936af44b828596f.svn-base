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
                $url = $y->makeURL();
                $childsArray[] = array(
                    'name' => $y->makeName(),
                    'url' =>  $url
                );
            }

            $image = false;

            if ($x->makeImageThumb()) {
                $image = $x->makeImageThumb(350, 347);
            } else {
                $product = Shop::Get()->getShopService()->getProductsByCategory($x);
                $product->addWhere('image', '', '<>');
                $product->setLimitCount(1);
                if ($w = $product->getNext()){
                    $image = $w->makeImageThumb(350, 347);
                }
            }

            $url = $x->makeURL();

            $a[] = array(
                'name' => $x->makeName(),
                'url' => $url,
                'image' => $image,
                'childsArray' => $childsArray,
            );
        }

        $this->setValue('subcategoriesArray', $a);
    }

}