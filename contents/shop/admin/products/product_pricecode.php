<?php
class product_pricecode extends Engine_Class {

    public function process() {
        try {
            $product = Shop::Get()->getShopService()->getProductByID(
            $this->getArgument('id')
            );

            $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();

            $this->setValue('id', $product->getId());
            $this->setValue('name', $product->makeName());

            try {
                $price = $this->getArgument('price');
            } catch (Exception $e) {
                $price = $product->makePrice($currency);
            }
            $this->setValue('price', $price);

            $this->setValue('currency', $currency->getSymbol());
            $this->setValue('info', $product->makeCharacteristicsString());
            //$this->setValue('barcode', $product->makeBarcodeImageInternal());
            $this->setValue('url', Engine::Get()->getProjectHost());
            $this->setValue('date', date('YmdHis'));

            $count = $this->getArgumentSecure('count', 'int');
            if ($count <= 1) {
                $count = 1;
            }
            $this->setValue('count', $count);
        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}