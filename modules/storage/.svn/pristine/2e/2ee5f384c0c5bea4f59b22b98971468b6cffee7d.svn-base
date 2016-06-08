<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * событие для Sync
 *
 * @author    i.ustimenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Storage_Sync implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        try {
            SQLObject::TransactionStart();

            $sync = new SQLObjectSync_Data(new XShopDocumentTemplate());

            $languagesArray = array(
                'ukr' => 'UA',
                'ru' => 'RU',
                'eng' => 'EN',
            );

            foreach ($languagesArray as $key => $name) {
                $sync->addData(
                    array(
                        'key' => 'order-act-'.$key
                    ),
                    array(
                        'name' => 'Акт выполненных работ ('.$name.')',
                        'content' => 'file:/modules/document/media/shop-document-akt-'.$key.'.html',
                        'type' => 'ShopOrder'
                    )
                );

                $sync->addData(
                    array(
                        'key' => 'invoice-'.$key
                    ),
                    array(
                        'name' => 'Счет-фактура ('.$name.')',
                        'content' => 'file:/modules/document/media/shop-document-invoice-'.$key.'.html',
                        'type' => 'ShopOrder'
                    )
                );

                $sync->addData(
                    array(
                        'key' => 'salebill-'.$key
                    ),
                    array(
                        'name' => 'Накладная заказа ('.$name.')',
                        'content' => 'file:/modules/document/media/shop-document-salebill-'.$key.'.html',
                        'type' => 'ShopOrder'
                    )
                );
            }

            $sync->sync();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
        try {
            
            SQLObject::TransactionStart();

            try {
                StorageNameService::Get()->getStorageNameSold();
            } catch (ServiceUtils_Exception $se) {
                $storageName = new ShopStorageName();
                $storageName->setName('Продажи');
                $storageName->setIssold(1);
                $storageName->insert();
            }

            try {
                StorageNameService::Get()->getStorageNameProduction();
            } catch (ServiceUtils_Exception $se) {
                $storageName = new ShopStorageName();
                $storageName->setName('Производство');
                $storageName->setIsproduction(1);
                $storageName->insert();
            }

            try {
                StorageNameService::Get()->getStorageNameOutcoming();
            } catch (ServiceUtils_Exception $se) {
                $storageName = new ShopStorageName();
                $storageName->setName('Расход');
                $storageName->setIsoutcoming(1);
                $storageName->insert();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
        
        // документы
        if (Shop_ModuleLoader::Get()->isImported('document')) {
            try {
                SQLObject::TransactionStart();

                $sync = new SQLObjectSync_Data(new XShopDocumentTemplate());

                $languagesArray = array(
                    'ukr' => 'UA',
                    'ru' => 'RU',
                    'eng' => 'EN',
                );

                foreach ($languagesArray as $key => $name) {
                    $sync->addData(
                        array(
                            'key' => 'barcodes-internal-'.$key
                        ),
                        array(
                            'name' => 'Штрих-коды внутренние ('.$name.')',
                            'content' => 'file:/modules/storage/media/shop-document-barcodes-internal-'.$key.'.html',
                            'type' => 'ShopProduct'
                        )
                    );

                    $sync->addData(
                        array(
                            'key' => 'barcodes-external-'.$key
                        ),
                        array(
                            'name' => 'Штрих-коды внешние ('.$name.')',
                            'content' => 'file:/modules/storage/media/shop-document-barcodes-external-'.$key.'.html',
                            'type' => 'ShopProduct'
                        )
                    );

                    $sync->addData(
                        array(
                            'key' => 'storage-salebill-'.$key
                        ),
                        array(
                            'name' => 'Накладная заказа ('.$name.')',
                            'content' => 'file:/modules/storage/media/shop-document-salebill-'.$key.'.html',
                            'type' => 'ShopStorageOrder'
                        )
                    );

                    $sync->addData(
                        array(
                            'key' => 'storage-transaction-'.$key
                        ),
                        array(
                            'name' => 'Перемещение ('.$name.')',
                            'content' => 'file:/modules/storage/media/shop-document-transfer-'.$key.'.html',
                            'type' => 'ShopStorageTransaction'
                        )
                    );
                }

                $sync->sync();

                SQLObject::TransactionCommit();
            } catch (Exception $ge) {
                SQLObject::TransactionRollback();
                throw $ge;
            }
        }
    }

}