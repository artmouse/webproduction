<?php
class storage_passport_delete extends Engine_Class {

    public function process() {
        try {
            $passport = StorageProductionService::Get()->getProductPassportByID(
            $this->getArgument('id')
            );

            $this->setValue('id', $passport->getId());
            $this->setValue('name', $passport->getName());

            if ($this->getControlValue('ok')) {
                try {
                    StorageProductionService::Get()->deleteProductPassport($passport);

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