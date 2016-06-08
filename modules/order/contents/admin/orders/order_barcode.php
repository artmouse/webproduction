<?php
class order_barcode extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
            $this->getArgument('id')
            );

            $orderProducts = $order->getOrderProducts();
            $barcodeArray = array();
            while ($orderProduct = $orderProducts->getNext()) {
                try {
                    $product = $orderProduct->getProduct();

                    $count = $orderProduct->getProductcount();
                    if ($count >= 5) {
                        $count = 1;
                    }

                    for ($i = 0; $i < $count; $i++) {
                        $barcodeArray[] = array(
                        'id' => $product->getId(),
                        'name' => $product->makeName(),
                        'barcode' => $product->makeBarcodeImageInternal()
                        );
                    }

                } catch (ServiceUtils_Exception $se) {

                }
            }

            $this->setValue('barcodeArray', $barcodeArray);
            $this->setValue('slogan', Engine::Get()->getProjectHost());
        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}