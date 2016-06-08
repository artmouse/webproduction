<?php
class delivery_add extends Engine_Class {

    public function process() {
        PackageLoader::Get()->import('CKFinder');

        if ($this->getControlValue('ok')) {
            try {
                SQLObject::TransactionStart();

                $delivery = Shop::Get()->getDeliveryService()->addDelivery(
                $this->getControlValue('name')
                );

                $image = $this->getControlValue('image');
                $image = @$image['tmp_name'];

                Shop::Get()->getDeliveryService()->updateDelivery(
                $delivery,
                $delivery->getName(),
                $this->getControlValue('price'),
                $this->getControlValue('currency'),
                $this->getControlValue('needcity'),
                $this->getControlValue('needaddress'),
                $this->getControlValue('description'),
                $this->getControlValue('sort'),
                $image,
                false,
                $this->getControlValue('paydelivery'),
                $this->getControlValue('logic'),
                $this->getControlValue('needcountry'),
                $this->getControlValue('default')
                );

                SQLObject::TransactionCommit();

                $this->setValue('message', 'ok');
                $this->setValue('urlredirect', Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-delivery-edit', $delivery->getId()));
            } catch (ServiceUtils_Exception $e) {
                SQLObject::TransactionRollback();
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }

                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $e->getErrorsArray());
            }
        }

        // список валют
        $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
        $this->setValue('currencyArray', $currency->toArray());

    }

}