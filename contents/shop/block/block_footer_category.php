<?php
class block_footer_category extends Engine_Class {

    public function process() {
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $category->setHidden(0);
        $category->setParentid(0);

        $a = array();
        while ($x = $category->getNext()) {
            $a[] = array(
            'name' => $x->makeName(),
            'url' => $x->makeURL(),
            'productCount' => $x->getProductcount(),
            );
        }

        $this->setValue('categoryArray', $a);
    }

}