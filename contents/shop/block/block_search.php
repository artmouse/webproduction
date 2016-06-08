<?php
class block_search extends Engine_Class {

    public function process() {
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $category->setParentid(0);
        $category->setHidden(0);
        $this->setValue('categoryArray',$category->toArray());
        $this->setValue('categoryIdSelected',$this->getValue('categoryIdSelected'));
    }

}