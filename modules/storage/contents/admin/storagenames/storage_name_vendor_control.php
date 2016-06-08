<?php
class storage_name_vendor_control extends Engine_Class {

    public function process() {
        $form = new Forms_ContentForm(new Datasource_StorageName('vendor'));
        $form->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_vendor_name'));
        $form->getField('userid')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_responsible'));
        $form->removeField('forsale');

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