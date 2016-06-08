<?php
class delivery_delete extends Engine_Class {

    public function process() {
        try {
            $delivery = Shop::Get()->getDeliveryService()->getDeliveryByID(
                $this->getArgument('id')
            );

            $this->setValue('deliveryid', $delivery->getId());
            $this->setValue('name', htmlspecialchars($delivery->getName()));

            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_udalenie_dostavki_').
                $delivery->getId()
            );

            if ($this->getControlValue('ok')) {
                try {
                    Shop::Get()->getDeliveryService()->deleteDelivery($delivery);

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}