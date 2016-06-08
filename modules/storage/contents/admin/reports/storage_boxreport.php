<?php
class storage_boxreport extends Engine_Class {

    public function process() {
        PackageLoader::Get()->import('JSPrototypeTableKit');
        $cuser = $this->getUser();

        if ($this->getControlValue('ok')) {
            $a = array();
            try {
                $storageName = StorageNameService::Get()->getStorageNameByID(
                $this->getControlValue('storagenameid')
                );

                $a = StorageService::Get()->getStorageBoxReport(
                $cuser,
                $storageName
                );

                $this->setValue('boxArray', $a);

            } catch (ServiceUtils_Exception $e) {
                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $e->getErrorsArray());

                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
        }

        // склады
        $storageNames = StorageService::Get()->getStorageNamesArrayByUser(
        $cuser,
        'read'
        );
        $this->setValue('storageNamesArray', $storageNames);
    }

}