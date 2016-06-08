<?php
/**
 * Если отредактировали поставщиков, то подправляем под них склады.
 *
 * @copyright WebProduction
 * @package   Storage
 */
class Storage_SyncNames {

    public function process() {
        // синхронизация поставщиков
        try {
            SQLObject::TransactionStart();

            // получаем всех поставщиков на складах
            $storageName = new ShopStorageName();
            $storageName->setIsvendor(1);
            $storageNameIDArray = array();
            while ($x = $storageName->getNext()) {
                $storageNameIDArray[$x->getId()] = $x;
            }

            $suppliers = Shop::Get()->getSupplierService()->getSuppliersActive();
            while ($supplier = $suppliers->getNext()) {
                $storageName = new ShopStorageName();
                $storageName->setIsvendor(1);
                $storageName->setLinkkey('supplier-'.$supplier->getId());
                if (!$storageName->select()) {
                    $storageName->setUserid($supplier->getContactid());
                    $storageName->setName($supplier->getName());
                    $storageName->insert();

                    unset($storageNameIDArray[$storageName->getId()]);
                } else {
                    $storageName->setUserid($supplier->getContactid());
                    $storageName->setName($supplier->getName());
                    $storageName->update();

                    unset($storageNameIDArray[$storageName->getId()]);
                }
            }

            // прячем всех старых поставщиков
            foreach ($storageNameIDArray as $x) {
                $x->setHidden(1);
                $x->update();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            print $ge;
        }


        /*
        // синхронизация пользователей
        try {
            SQLObject::TransactionStart();

            // получаем всех поставщиков на складах
            $storageName = new ShopStorageName();
            $storageName->setIsemployee(1);
            $storageNameIDArray = array();
            while ($x = $storageName->getNext()) {
                $storageNameIDArray[$x->getId()] = $x;
            }

            // для всех сотрудников
            // создаем склад-сотрудника
            $users = Shop::Get()->getUserService()->getUsersManagers();
            while ($user = $users->getNext()) {
                $storageName = new ShopStorageName();
                $storageName->setIsemployee(1);
                $storageName->setLinkkey('employee-'.$user->getId());
                if (!$storageName->select()) {
                    $storageName->setUserid($user->getId());
                    $storageName->setName($user->makeName(false, false));
                    $storageName->insert();

                    unset($storageNameIDArray[$storageName->getId()]);
                } else {
                    $storageName->setUserid($user->getId());
                    $storageName->setName($user->makeName(false, false));
                    $storageName->update();

                    unset($storageNameIDArray[$storageName->getId()]);
                }
            }

            // прячем всех старых поставщиков
            foreach ($storageNameIDArray as $x) {
                $x->setHidden(1);
                $x->update();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            print $ge;
        }
        */
    }

}