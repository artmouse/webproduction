<?php
class storage_motion_list extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            // фильтр по складу
            $storageName = false;
            try {
                $storageName = StorageNameService::Get()->getStorageNameByID(
                $this->getArgument('storagenameid')
                );

                if (!StorageNameService::Get()->isStorageOperationAllowed(
                $cuser,
                $storageName,
                'motionlog'
                )) {
                    $storageName = false;
                }
            } catch (Exception $e) {

            }
            
            // фильтр по складам
            $storageNameFromIDArray = $this->getArgumentSecure('storagenamefromid', 'array');
            $storageNameToIDArray = $this->getArgumentSecure('storagenametoid', 'array');
            
            // фильтр по дате
            $datefrom = $dateto = false;
            if ($this->getControlValue('datefrom')) {
                $datefrom = DateTime_Corrector::CorrectDateTime($this->getControlValue('datefrom'));
            }
            if ($this->getControlValue('dateto')) {
                $dateto = DateTime_Corrector::CorrectDateTime($this->getControlValue('dateto'));
            }

            // фильтр по типу
            $type = $this->getArgumentSecure('type');

            // таблица
            $table = new Shop_ContentTable(new Datasource_Storage_Motionlog(
            $type,
            $datefrom,
            $dateto,
            $storageName,
            $storageNameFromIDArray,
            $storageNameToIDArray,
            false,
            $this->getArgumentSecure('orderid')
            ));

            $table->removeField('id');
            $table->removeField('return');
            $this->setValue('table', $table->render());

            /*if (!$datefrom) {
                $this->setControlValue('datefrom', date('Y-m-d'));
            }
            if (!$dateto) {
                $this->setControlValue('dateto', date('Y-m-d'));
            }*/

            // склады
            $storageNameFromArray = array();
            $storageNameToArray = array();
            $storageNameFrom = false;
            $storageNameTo = false;
            $storageNameArray = StorageNameService::Get()->getStorageNameIDsArrayByUser($cuser, 'motionlog');

            if ($type == 'incoming') {
                $storageNameFrom = StorageNameService::Get()->getStorageNamesVendors();
                $storageNameTo = StorageNameService::Get()->getStorageNamesForTransfers();
            } elseif ($type == 'transfer') {
                $storageNameFrom = StorageNameService::Get()->getStorageNamesForTransfers();
                $storageNameTo = StorageNameService::Get()->getStorageNamesForTransfers();
            } elseif ($type == 'sale') {
                $storageNameFrom = StorageNameService::Get()->getStorageNamesForSale();
                $storageNameTo = StorageNameService::Get()->getStorageNameSold();
            } else {
                $storageNameFrom = StorageNameService::Get()->getStorageNamesActive();
                $storageNameFrom->setIsoutcoming(0);
                $storageNameFrom->setIsproduction(0);
                $storageNameFrom->setIssold(0);

                $storageNameTo = StorageNameService::Get()->getStorageNamesActive();
                $storageNameTo->setIsoutcoming(0);
                $storageNameTo->setIsproduction(0);
                $storageNameTo->setIsvendor(0);
            }

            if ($storageNameFrom) {
                while ($storageName = $storageNameFrom->getNext()) {
                    if (in_array($storageName->getId(), $storageNameArray)) {
                        $storageNameFromArray[] = $storageName->toArray();
                    }
                }
            }

            $this->setValue('storagenamefromArray', $storageNameFromArray);

            if ($storageNameTo) {
                while ($storageName = $storageNameTo->getNext()) {
                    if (in_array($storageName->getId(), $storageNameArray)) {
                        $storageNameToArray[] = $storageName->toArray();
                    }
                }
            }

            $this->setValue('storagenametoArray', $storageNameToArray);
            
            $this->setValue('storagenamefromid', $storageNameFromIDArray);
            $this->setValue('storagenametoid', $storageNameToIDArray);
            
            $this->setValue('type', $type);

        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}
