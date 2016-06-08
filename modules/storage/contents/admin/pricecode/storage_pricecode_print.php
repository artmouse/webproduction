<?php
class storage_pricecode_print extends Engine_Class {

    public function process() {
        try {
            $product = Shop::Get()->getShopService()->getProductByID(
            $this->getArgument('code')
            );

            $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();

            $this->setValue('name', $product->makeName());
            $this->setValue('info', $product->makeCharacteristicsString());
            $this->setValue('price', $product->makePrice($currency));
            $this->setValue('currency', $currency->getSymbol());
        } catch (Exception $productEx) {

        }

        if ($this->getControlValue('ok')) {
            try {
                $product = Shop::Get()->getShopService()->getProductByID(
                $this->getArgument('code')
                );

                $price = $this->getControlValue('price');
                $count = $this->getControlValue('count');

                $a = array();
                $a['id'] = $product->getId();

                if ($price) {
                    $a['price'] = $price;
                }
                if ($count) {
                    $a['count'] = $count;
                }

                $url = Engine::GetLinkMaker()->makeURLByContentIDParams(
                'shop-product-pricecode',
                $a
                );

                $this->setValue('urlPrint', $url);
            } catch (Exception $productEx) {

            }
        } else {
            $this->setControlValue('count', 1);
        }
    }

}