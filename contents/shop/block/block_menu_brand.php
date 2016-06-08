<?php
class block_menu_brand extends Engine_Class {

    public function process() {
        $this->setValue('brandAllUrl', Engine::GetLinkMaker()->makeURLByContentID('brand-all'));

        $a = array();
        $brands = Shop::Get()->getShopService()->getBrandsAll();
        $this->setValue('allBrandsCount', $brands->getCount());
        $brands->setHidden(0);
        $brands->setTop(1);
        $brands->addWhere('productcount', '1', '>');
        while ($x = $brands->getNext()) {
            $a[] = $x->makeInfoArray(25, 25);
        }

        $cnt = count($a);
        $this->setValue('brandsCount', $cnt);

        if ($cnt < 30) {
            $this->setValue('brandsBreak', 10);
        } else {
            $this->setValue('brandsBreak', ceil($cnt / 4));
        }

        $this->setValue('brandsArray', $a);
    }

}