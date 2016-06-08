<?php
class storage_motion_delete extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            // один из товаров в перемещении
            $storageProduct = StorageService::Get()->getStorageByID(
            $this->getArgument('id')
            );

            if ($storageProduct->getAmount() < 0) {
                // разрешено править только прямые записи
                throw new ServiceUtils_Exception();
            }

            if ($this->getControlValue('ok')) {
                try {
                    StorageService::Get()->deleteStorage(
                    $storageProduct,
                    $cuser
                    );

                    $this->setValue('message', 'ok');
                    $this->setValue('urlredirect', Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-motion-list'));
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());

                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
            }

            $this->setValue('productid', $storageProduct->getProductid());
            $this->setValue('productname', $storageProduct->getProduct()->getName());
            $this->setValue('productHistoryURL', $storageProduct->makeHistoryURL());
            $this->setValue('date', $storageProduct->getDate());
            $this->setValue('type', $storageProduct->makeType());
            $this->setValue('storagenamefrom', $storageProduct->getStorageNameFrom()->getName());
            $this->setValue('storagenamefromURL', $storageProduct->getStorageNameFrom()->makeURLMotionlog());
            $this->setValue('storagenameto', $storageProduct->getStorageNameTo()->getName());
            $this->setValue('storagenametoURL', $storageProduct->getStorageNameTo()->makeURLMotionlog());
            $this->setValue('price', $storageProduct->getPrice());
            $this->setValue('shipment', $storageProduct->getShipment());
            $this->setValue('isReturn', $storageProduct->getReturn());

            try {
                $this->setValue('currency', $storageProduct->getCurrency()->getSymbol());
            } catch (ServiceUtils_Exception $se) {

            }

            $this->setValue('tax', $storageProduct->getTaxrate());
            $this->setValue('amount', $storageProduct->getAmount());
            $this->setValue('unit', $storageProduct->getProduct()->getUnit());
            try {
                $this->setValue('username', $storageProduct->getUser()->getName());
            } catch (ServiceUtils_Exception $se) {

            }
            
            $this->setValue('urlcancel', Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-storage-motion-view', $storageProduct->getId()));
         
            // ссылка на журнал
            $this->setValue('urlMotion', Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-admin-storage-motion-view',
            $storageProduct->getId()
            ));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}