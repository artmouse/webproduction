<?php
class storage_motion_product extends Engine_Class {

    public function process() {
        try {
            $code = $this->getArgument('code');
            $cuser = $this->getUser();

            try {
                $storageProduct = StorageService::Get()->getStorageByCode(
                $cuser,
                $code
                );

                $this->setValue('cdate', DateTime_Formatter::DateTimeRussianGOST($storageProduct->getDate()));
                $this->setValue('productid', $storageProduct->getProductid());
                $this->setValue('shipment', $storageProduct->getShipment());

                try {
                    $this->setValue('user', $storageProduct->getUser()->getName());
                } catch (ServiceUtils_Exception $se) {

                }

                $product = $storageProduct->getProduct();
                $this->setValue('productname', $storageProduct->getProductname());
                $this->setValue('productURL', $product->makeURLEdit());

                $this->setValue('price', $storageProduct->getPricebase());
            } catch (ServiceUtils_Exception $se) {

            }

            $this->setValue('currency', Shop::Get()->getCurrencyService()->getCurrencySystem()->getSymbol());

            $table = new Shop_ContentTable(new Datasource_Storage_ProductHistory($code));
            $table->removeField('id');
            $table->removeField('return');
            $table->removeField('transactionid');

            $field = new Shop_ContentField_Link('date', 'shop-admin-storage-motion-view', 'transactionid','id');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_date'));
            $table->addField($field);

            $this->setValue('table', $table->render());
        } catch (Exception $e) {
            //print $e;

        }
    }

}