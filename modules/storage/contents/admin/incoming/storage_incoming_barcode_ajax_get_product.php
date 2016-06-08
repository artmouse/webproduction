<?php
class storage_incoming_barcode_ajax_get_product extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $barcode = trim($this->getArgument('barcode'));
            if (!$barcode) {
                throw new ServiceUtils_Exception();
            }

            $product = false;

            try {
                $product = Shop::Get()->getShopService()->getProductByBarcode($barcode);
            } catch (Exception $se) {}

            if (!$product) {
                $product = Shop::Get()->getShopService()->getProductByID($barcode);
            }
            
            print json_encode(array(
            'id' => $product->getId(),
            'name' => $product->getName()
            ));
            exit();

        } catch (Exception $e) {
            echo json_encode(array('error' => 'error'));
            exit();
        }
    }

}