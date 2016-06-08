<?php
class storage_motion_balance_history extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $balance = StorageBalanceService::Get()->getBalanceByID(
            $this->getArgumentSecure('balanceid')
            );

            // таблица
            $table = new Shop_ContentTable(new Datasource_Storage_Motionlog(
            false,
            false,
            false,
            $balance->getStorageName(),
            false,
            false,
            false,
            false,
            $balance->getProductid()
            ));

            $table->removeField('id');
            $table->removeField('return');
            $this->setValue('table', $table->render());

            $this->setValue('productName', $balance->getProductname());
            $this->setValue('storageName', $balance->getStorageName()->getName());

        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
    }

}