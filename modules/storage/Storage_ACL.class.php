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
 * Подгрузка ACL по требованию
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Storage_ACL implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        Shop::Get()->getUserService()->addACLPermission('storage', 'Складской учет');
        Shop::Get()->getUserService()->addACLPermission('storage-incoming', 'Складской учет :: Оприходование');
        Shop::Get()->getUserService()->addACLPermission(
            'storage-transfer',
            'Складской учет :: Перемещение/Производство'
        );
        Shop::Get()->getUserService()->addACLPermission('storage-sale', 'Складской учет :: Отгрузка');
        Shop::Get()->getUserService()->addACLPermission('storage-sale-quick', 'Складской учет :: Быстрая продажа');
        Shop::Get()->getUserService()->addACLPermission('storage-production', 'Складской учет :: Производство');
        Shop::Get()->getUserService()->addACLPermission(
            'storage-outcoming',
            'Складской учет :: Списание'
        );

        Shop::Get()->getUserService()->addACLPermission('storage-balance', 'Складской учет :: Просмотр баланса');
        Shop::Get()->getUserService()->addACLPermission(
            'storage-balance-vendors',
            'Складской учет :: Отчет о закупках'
        );
        Shop::Get()->getUserService()->addACLPermission(
            'storage-balance-sales',
            'Складской учет :: Отчет об отгрузках'
        );

        Shop::Get()->getUserService()->addACLPermission('storage-motionlog', 'Складской учет :: Журнал');

        Shop::Get()->getUserService()->addACLPermission(
            'storage-motionlog-edit',
            'Складской учет :: Редактирование записей журнала'
        );
        Shop::Get()->getUserService()->addACLPermission(
            'storage-motionlog-delete',
            'Складской учет :: Удаление записей журнала'
        );

        Shop::Get()->getUserService()->addACLPermission('storage-motionlog-return', 'Складской учет :: Возврат');

        Shop::Get()->getUserService()->addACLPermission('storage-report-sales', 'Складской учет :: Отчет по прибыли');
        Shop::Get()->getUserService()->addACLPermission(
            'storage-report-motion',
            'Складской учет :: Отчет об изменении баланса'
        );

        Shop::Get()->getUserService()->addACLPermission('storage-barcode', 'Складской учет :: Штрих-кодирование');
        Shop::Get()->getUserService()->addACLPermission('storage-settings', 'Складской учет :: Настройки');
        Shop::Get()->getUserService()->addACLPermission('storage-passports', 'Складской учет :: Паспорта товаров');

        Shop::Get()->getUserService()->addACLPermission('storage-orders', 'Складской учет :: Заказы');
        Shop::Get()->getUserService()->addACLPermission(
            'storage-orders-edit',
            'Складской учет :: Заказы: редактирование'
        );

        // ACL по каждому складу
        $storageNames = StorageNameService::Get()->getStorageNamesAll();
        $storageNames->setIsproduction(0);
        $operation = array(
            'read' => 'Просмотр баланса',
            'motionlog' => 'Журнал',
        );

        while ($storageName = $storageNames->getNext()) {
            $type = '';
            if ($storageName->getIsemployee()) {
                $type = ' сотрудника ';
            } elseif ($storageName->getIsvendor()) {
                $type = ' поставщика ';
            } elseif (!$storageName->getIssold()) {
                $type = ' склада ';
            }

            foreach ($operation as $key => $name) {
                Shop::Get()->getUserService()->addACLPermission(
                    'storagename-'.$storageName->getId().'-'.$key,
                    'Складской учет :: '.$name.' :: '.$name.' '.$type.$storageName->getName()
                );
            }
        }

        $storageNames = StorageNameService::Get()->getStorageNamesForTransfers();
        $operation = array(
            'incomingto' => 'Оприходование',
            'transferto' => 'Перемещение/Производство',
            'returnto' => 'Возврат'
        );

        while ($storageName = $storageNames->getNext()) {
            $type = '';
            if ($storageName->getIsemployee()) {
                $type = ' на сотрудника ';
            } else {
                $type = ' на склад ';
            }

            foreach ($operation as $key => $name) {
                Shop::Get()->getUserService()->addACLPermission(
                    'storagename-'.$storageName->getId().'-'.$key,
                    'Складской учет :: '.$name.' :: '.$name.' '.$type.$storageName->getName()
                );
            }
        }

        $storageNames = StorageNameService::Get()->getStorageNamesForTransfers();
        $operation = array(
            'transferfrom' => 'Перемещение/Производство'
        );

        while ($storageName = $storageNames->getNext()) {
            $type = '';
            if ($storageName->getIsemployee()) {
                $type = ' от сотрудника ';
            } else {
                $type = ' со склада ';
            }

            foreach ($operation as $key => $name) {
                Shop::Get()->getUserService()->addACLPermission(
                    'storagename-'.$storageName->getId().'-'.$key,
                    'Складской учет :: '.$name.' :: '.$name.' '.$type.$storageName->getName()
                );
            }
        }

        $storageNames = StorageNameService::Get()->getStorageNamesVendors();
        $operation = array(
            'incomingfrom' => 'Оприходование'
        );

        while ($storageName = $storageNames->getNext()) {
            foreach ($operation as $key => $name) {
                Shop::Get()->getUserService()->addACLPermission(
                    'storagename-'.$storageName->getId().'-'.$key,
                    'Складской учет :: '.$name.' :: '.$name.' от поставщика '.$storageName->getName()
                );
            }
        }

        $storageNames = StorageNameService::Get()->getStorageNamesForSale();
        $operation = array(
            'salefrom' => 'Продажа'
        );

        while ($storageName = $storageNames->getNext()) {
            $type = '';
            if ($storageName->getIsemployee()) {
                $type = ' от сотрудника ';
            } else {
                $type = ' со склада ';
            }

            foreach ($operation as $key => $name) {
                Shop::Get()->getUserService()->addACLPermission(
                    'storagename-'.$storageName->getId().'-'.$key,
                    'Складской учет :: '.$name.' :: '.$name.' '.$type.$storageName->getName()
                );
            }
        }
    }

}