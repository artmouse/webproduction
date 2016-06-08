<?php
class storage_balance_product extends Engine_Class {

    public function process() {
        $productID = $this->getArgumentSecure('productid');

        if ($productID) {
            try {
                $product = Shop::Get()->getShopService()->getProductByID($productID);

                // таблица
                $table = new Shop_ContentTable(new Datasource_Balance_Product(
                $product
                ));

                $table->removeField('id');
                $this->setValue('table', $table->render());

                $this->setValue('productid', $productID);
                $this->setValue('productname', $product->getName());

            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
        }
    }

}