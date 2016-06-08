<?php
class order_add_product_list extends Engine_Class {

    public function process() {

        // категории
        $category = Shop::Get()->getShopService()->makeCategoryTree();
        $a = array();
        foreach ($category as $x) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                'level' => $x->getField('level'),
            );
        }
        $this->setValue('categoryArray', $a);

    }

}