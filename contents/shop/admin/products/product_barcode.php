<?php
class product_barcode extends Engine_Class {

    public function process() {
        try {
            $product = Shop::Get()->getShopService()->getProductByID(
            $this->getArgument('id')
            );

            $this->setValue('id', $product->getId());
            $this->setValue('name', $product->makeName());
            $this->setValue('barcode', $product->makeBarcodeImageInternal());
            //$this->setValue('slogan', Shop::Get()->getSettingsService()->getSettingValue('shop-name'));
            $this->setValue('url', Engine::Get()->getProjectHost());
            $this->setValue('date', date('YmdHis'));
        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}