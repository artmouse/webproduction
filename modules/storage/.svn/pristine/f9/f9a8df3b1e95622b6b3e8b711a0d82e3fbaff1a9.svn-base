<?php
class storage_outcoming extends Engine_Class {

    public function process() {
        $cuser = $this->getUser();

        // process transfer
        if ($this->getControlValue('process')) {
            try {
                $storageID = StorageTransferService::Get()->processOutcoming(
                $cuser,
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
                    $this->setValue('messageinfo', 'notransfer');
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
        $baskets = StorageTransferService::Get()->getOutcomingsByUser($cuser);
        while ($basket = $baskets->getNext()) {
            try {
                $storageName = $basket->getStorageName();
            } catch (Exception $e) {}
        }

        if ($storageName) {
            $this->setControlValue('storagefromid', $storageName->getId());
            $this->setValue('storagefromname', $storageName->getName());

            // форма добавления товара
            $block = Engine::GetContentDriver()->getContent('shop-admin-storage-basket-block-form');
            $block->setValue('type', 'outcoming');
            $block->setValue('storagenameid', $storageName->getId());
            $this->setValue('block_form', $block->render());
        }

        // таблица товаров в корзине
        $block = Engine::GetContentDriver()->getContent('shop-admin-storage-basket-block-table');
        $block->setValue('type', 'outcoming');
        $this->setValue('block_table', $block->render());

        // все склады с которых можно перемещать
        $storageNames = StorageNameService::Get()->getStorageNamesForTransferFromByUser(
        $cuser
        );
        $this->setValue('storagesfromArray', $storageNames->toArray());

        $this->setControlValue('date', date('Y-m-d H:i:s'));
    }

}