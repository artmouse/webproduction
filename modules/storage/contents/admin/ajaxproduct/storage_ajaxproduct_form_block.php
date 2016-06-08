<?php
class storage_ajaxproduct_form_block extends Engine_Class {

    public function process() {
        // валюты
        $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
        $this->setValue('currencyArray', $currency->toArray());

        // количество товара по умолчанию
        $this->setControlValue('count', 1);

        // список категорий
        $category = Shop::Get()->getShopService()->makeCategoryTree();
        $a = array();
        foreach ($category as $x) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            'hidden' => $x->getHidden(),
            'level' => $x->getField('level'),
            'selected' => $x->getId() == $this->getArgumentSecure('categoryid'),
            'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $x->getId())),
            'parentid' => $x->getParentid(),
            );
        }
        $this->setValue('categoryArray', $a);

        // разрешение группировать результат поиска по категории товара
        if (!$this->getValue('noCategorySearch')) {
            $this->setValue('categorySearchAllowed', true);
        }

    }

}