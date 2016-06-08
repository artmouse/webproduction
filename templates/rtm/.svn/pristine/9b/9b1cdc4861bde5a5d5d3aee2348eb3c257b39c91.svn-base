<?php
class shop_search_autocomplete extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgumentSecure('name');

            $showNoImageProducts = Shop::Get()->getSettingsService()->getSettingValue('show-nophoto-products');

            $a = array();
            $products = Shop::Get()->getShopService()->searchProducts($query, false);
            $products->addWhere('showincategory', 1, '=');
            $products->setLimitCount(10);
            while ($x = $products->getNext()) {

                if (!$showNoImageProducts && !$x->getImage()) {
                    continue;
                }

                $a[] = array(
                    'id' => $x->getId(),
                    'name' => htmlspecialchars($x->getName()),
                    'url' => $x->makeURL(),
                );
            }
            $this->setValue('productArray', $a);
        } catch (Exception $e) {

        }
    }


}