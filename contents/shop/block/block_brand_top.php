<?php
class block_brand_top extends Engine_Class {

    public function process() {
        $brands = Shop::Get()->getShopService()->getBrandsTop();
        $a = array();
        while ($x = $brands->getNext()) {
            $a[] = array(
            'name' => $x->makeName(),
            'image' => $x->makeImageThumb(100, 100, 'prop'),
            'url' => $x->makeURL(),
            );
        }
        $this->setValue('brandArray', $a);
    }

}