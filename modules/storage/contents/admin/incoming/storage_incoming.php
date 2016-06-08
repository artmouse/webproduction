<?php
class storage_incoming extends Engine_Class {

    public function process() {
        $cuser = $this->getUser();

        // проводим приход
        if ($this->getControlValue('process')) {
            try {
                $storageID = StorageIncomingService::Get()->processIncomings(
                    $cuser,
                    $this->getControlValue('supplierid'),
                    $this->getControlValue('storagenameid'),
                    $this->getControlValue('document'),
                    $this->getControlValue('request'),
                    $this->getControlValue('date'),
                    $this->getControlValue('contractorid')
                );

                if ($storageID) {
                    $this->setValue('messageprocess', 'ok');

                    // если товары были оприходованы, редиректимся
                    // на страницу просмотра прихода
                    $this->setValue(
                        'urlredirect',
                        Engine::GetLinkMaker()->makeURLByContentIDParam(
                            'shop-admin-storage-motion-view',
                            $storageID
                        )
                    );
                } else {
                    $this->setValue('messageinfo', 'noincoming');
                }
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('messageprocess', 'error');

                $errorArray = array();
                $exArray = $e->getErrorsArray();

                foreach ($exArray as $error) {
                    if (preg_match("/^(\d+):(\w+)$/uis", $error, $r)) {
                        try {
                            $incoming = StorageService::Get()->getStorageBasketByID($r[1]);
                            $product = $incoming->getProduct();

                            $errorArray[] = array(
                            'product' => '#'.$product->getId().' - '.$product->getName().' ('.
                                $incoming->getAmount().' '.$product->getUnit().')',
                            'error' => $r[2]
                            );
                        } catch (ServiceUtils_Exception $re) {

                        }
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

        // форма добавления товара
        $block = Engine::GetContentDriver()->getContent('shop-admin-storage-basket-block-form');
        $block->setValue('type', 'incoming');
        $this->setValue('block_form', $block->render());

        // форма импорта товаров
        $block = Engine::GetContentDriver()->getContent('shop-admin-storage-basket-block-import');
        $this->setValue('block_import', $block->render());

        // таблица товаров в корзине прихода
        $block = Engine::GetContentDriver()->getContent('shop-admin-storage-basket-block-table');
        $block->setValue('type', 'incoming');
        $this->setValue('block_table', $block->render());

        // поставщики
        $suppliers = StorageNameService::Get()->getStorageNamesForIncomingFromByUser($cuser);
        $this->setValue('suppliersArray', $suppliers->toArray());

        // склады
        $storageNames = StorageNameService::Get()->getStorageNamesForIncomingToByUser($cuser);
        $this->setValue('storagesArray', $storageNames->toArray());

        // юр лица
        $contractors = Shop::Get()->getShopService()->getContractorsActive();
        $this->setValue('contractorArray', $contractors->toArray());

        $this->setControlValue('date', date('Y-m-d H:i:s'));
    }

}