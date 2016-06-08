<?php
class storage_motion extends Engine_Class {

    public function process() {
        PackageLoader::Get()->import('JSPrototypeTableKit');

        $cuser = $this->getUser();

        if ($this->getControlValue('ok')) {
            $a = array();
            try {
                $storageNameID = $this->getControlValue('storagenameid');
                $datefrom = DateTime_Corrector::CorrectDateTime($this->getControlValue('datefrom'));
                $dateto = DateTime_Corrector::CorrectDateTime($this->getControlValue('dateto'));

                $storageName = Shop::Get()->Get()->getStorageService()->getStorageNameByID(
                $storageNameID
                );

                $a = Shop::Get()->getStorageReportService()->getStorageMotion(
                $storageName,
                $cuser,
                $datefrom,
                $dateto
                );

                $this->setValue('motionsArray', $a);

            } catch (ServiceUtils_Exception $se) {
                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $se->getErrorsArray());

                if (PackageLoader::Get()->getMode('debug')) {
                    print $se;
                }
            }
        }

        $storageNames = StorageService::Get()->getStorageNamesArrayByUser(
        $cuser,
        'read'
        );
        $this->setValue('storageNamesArray', $storageNames);

        if (empty($datefrom)) {
            $this->setControlValue('datefrom', date('Y-m-d'));
        }
        if (empty($dateto)) {
            $this->setControlValue('dateto', date('Y-m-d'));
        }
    }

}