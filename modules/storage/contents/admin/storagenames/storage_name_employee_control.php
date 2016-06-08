<?php
class storage_name_employee_control extends Engine_Class {

    public function process() {
        $form = new Forms_ContentForm(new Datasource_StorageName('employee'));
        $form->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_employee_name'));
        $form->getField('userid')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_responsible'));
        $form->getField('forsale')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_employee_can_sale'));

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