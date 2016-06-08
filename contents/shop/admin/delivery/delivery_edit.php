<?php
class delivery_edit extends Engine_Class {

    public function process() {
        PackageLoader::Get()->import('CKFinder');

        try {
            $delivery = Shop::Get()->getDeliveryService()->getDeliveryByID(
                $this->getArgument('id')
            );

            $this->setValue('deliveryid', $delivery->getId());
            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_dostavka_').$delivery->getId()
            );

            if ($this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();

                    $image = $this->getControlValue('image');
                    $image = @$image['tmp_name'];

                    Shop::Get()->getDeliveryService()->updateDelivery(
                        $delivery,
                        $this->getControlValue('name'),
                        $this->getControlValue('price'),
                        $this->getControlValue('currency'),
                        $this->getControlValue('needcity'),
                        $this->getControlValue('needaddress'),
                        $this->getControlValue('description'),
                        $this->getControlValue('sort'),
                        $image,
                        $this->getControlValue('deleteimage'),
                        $this->getControlValue('paydelivery'),
                        $this->getControlValue('logic'),
                        $this->getControlValue('needcountry'),
                        $this->getControlValue('default')
                    );

                    $this->setValue('message', 'ok');

                    SQLObject::TransactionCommit();
                } catch (ServiceUtils_Exception $e) {
                    SQLObject::TransactionRollback();

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

            $this->setControlValue('name', $delivery->getName());
            $this->setControlValue('price', $delivery->getPrice());
            $this->setControlValue('currency', $delivery->getCurrencyid());
            $this->setControlValue('needcity', $delivery->getNeedcity());
            $this->setControlValue('needcountry', $delivery->getNeedcountry());
            $this->setControlValue('needaddress', $delivery->getNeedaddress());
            $this->setControlValue('paydelivery', $delivery->getPaydelivery());
            $this->setControlValue('default', $delivery->getDefault());
            $this->setControlValue('description', $delivery->getDescription());
            $this->setControlValue('sort', $delivery->getSort());
            $this->setControlValue('logic', $delivery->getLogicclass());
            $this->setValue('imagesrc', $delivery->getImage());
            $this->setValue('image', $delivery->makeImageThumb(200));

            // список валют
            $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
            $this->setValue('currencyArray', $currency->toArray());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}