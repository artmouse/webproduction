<?php
class shop_brands extends Engine_Class {

    public function process() {
        $a = array();

        $brands = Shop::Get()->getShopService()->getBrandsAll();
        $brands->setHidden(0);

        $a['others'] = array();
        while ($x = $brands->getNext()) {
            $brandName = $x->getName();
            $rest = mb_substr(trim($brandName), 0, 1);
            $a[$rest][] = $x->makeInfoArray(25, 25);
        }

        foreach ($a as $k => $v) {
            if (preg_match("/^[\d\w]+/ius", $k) === 0 || is_numeric($k)) {
                @$a['others'] = array_merge($a['others'], $v);
                unset($a[$k]);
            }
        }

        $this->setValue('brandsArray', $a);
    }

}