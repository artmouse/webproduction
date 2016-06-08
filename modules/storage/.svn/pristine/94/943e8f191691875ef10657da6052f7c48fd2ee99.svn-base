<?php
class storage_passport_add extends Engine_Class {

    public function process() {
        try {
            $passport = StorageProductionService::Get()->addProductPassport();

            $urlRedirect = Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-admin-storage-product-passport-edit',
            $passport->getId()
            );
            
            $this->setValue('urlredirect', $urlRedirect);
        } catch (Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}