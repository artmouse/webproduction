<?php
class storage_name_control extends Engine_Class {

    public function process() {
        $form = new Forms_ContentForm(new Datasource_StorageName('warehouse'));

        $storageNameID = $this->getArgumentSecure('key');

        try {
            $storageName = StorageNameService::Get()->getStorageNameByID($storageNameID);
            if ($storageNameID) {
                $form->denyInsert();
            }

            if ($storageName->getStorageRecords()->getCount()) {
                $form->denyDelete();
            }

        } catch (Exception $e) {

        }

        $this->setValue('form', $form->render($storageNameID));
    }

}