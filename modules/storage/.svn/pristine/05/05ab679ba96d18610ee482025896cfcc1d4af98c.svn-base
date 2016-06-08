<?php
class storage_production extends Engine_Class {

    public function process() {
        $cuser = $this->getUser();

        // process production
        if ($this->getControlValue('process')) {
            try {
                $storageID = StorageProductionService::Get()->processProduction(
                $cuser,
                $this->getControlValue('storagetoid'),
                $this->getControlValue('date')
                );

                if ($storageID) {
                    $this->setValue('messageprocess', 'ok');

                    // если товары были оприходованы, редиректимся
                    // на страницу просмотра прихода
                    $this->setValue('urlredirect',
                    Engine::GetLinkMaker()->makeURLByContentIDParam(
                    'shop-admin-storage-motion-view',
                    $storageID
                    ));
                } else {
                    $this->setValue('messageinfo', 'noproduction');
                }
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('messageprocess', 'error');

                $errorArray = array();
                $exArray = $e->getErrorsArray();

                foreach ($exArray as $error) {
                    if (preg_match("/^(\d+):(\w+)$/uis", $error, $r)) {
                        try {
                            $basket = StorageService::Get()->getStorageBasketByID($r[1]);
                            $product = $basket->getProduct();

                            $errorArray[] = array(
                            'product' => '#'.$product->getId().' - '.$product->getName().' ('.$basket->getAmount().' '.$product->getUnit().')',
                            'error' => $r[2]
                            );
                        } catch (ServiceUtils_Exception $re) {}
                    } else {
                        $errorArray[] = array(
                        'error' => $error
                        );
                    }
                }

                $this->setValue('errorsArray', $errorArray);

                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
        }

        // определяем, выбран ли склад, с которого будут перемещаться товары
        $storageName = false;

        try {
            $storageName = StorageNameService::Get()->getStorageNameByID(
            $this->getControlValue('storagefromid')
            );
        } catch (Exception $e) {}

        // товары в корзине
        $productions = StorageProductionService::Get()->getProductionsByUser($cuser);
        while ($production = $productions->getNext()) {
            try {
                $storageName = $production->getStorageName();
            } catch (Exception $e) {}
        }

        if ($storageName) {
            $this->setControlValue('storagefromid', $storageName->getId());
            $this->setValue('storagefromname', $storageName->getName());

            // форма добавления товара
            $block = Engine::GetContentDriver()->getContent('shop-admin-storage-ajax-product-form-block');
            $block->setValue('formID', 'id-form-production-add');
            $block->setValue('isProduction', true);
            $block->setValue('noCategorySearch', true);
            $parameterArray = array();
            $parameterArray[] = array('name' => 'storagefromid', 'value' => $storageName->getId());
            $block->setValue('parameterArray', $parameterArray);
            $this->setValue('addForm', $block->render());
        }

        // таблица товаров в корзине
        $block = Engine::GetContentDriver()->getContent('shop-admin-storage-production-table-block');
        $block->setValue('istarget', true);
        $this->setValue('productTable', $block->render());
        
        $block = Engine::GetContentDriver()->getContent('shop-admin-storage-production-table-block');
        $block->setValue('istarget', false);
        $this->setValue('materialTable', $block->render());
        
        // таблица паспортов товаров в корзине
        $block = Engine::GetContentDriver()->getContent('shop-admin-storage-production-passport-table-block');
        $this->setValue('passportTable', $block->render());

        // все склады с которых можно перемещать
        $storageNames = StorageNameService::Get()->getStorageNamesForTransferFromByUser(
        $cuser
        );
        $this->setValue('storagesfromArray', $storageNames->toArray());

        // все склады на которые можно перемещать
        $storageNames = StorageNameService::Get()->getStorageNamesForTransferToByUser(
        $cuser
        );
        $this->setValue('storagestoArray', $storageNames->toArray());
        
        $this->setControlValue('date', date('Y-m-d H:i:s'));
    }

}