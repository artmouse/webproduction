<?php
class storage_report_motion extends Engine_Class {

    public function process() {
        $cuser = $this->getUser();
        $storageNameIDArray = $this->getArgumentSecure('storagenameid', 'array');

        if ($this->getControlValue('ok')) {
            $a = array();
            try {
                $datefrom = DateTime_Corrector::CorrectDateTime($this->getControlValue('datefrom'));
                $dateto = DateTime_Corrector::CorrectDateTime($this->getControlValue('dateto'));

                $page = $this->getArgumentSecure('page');
                $onPage = 300;
                $pageStep = 3;

                $limitFrom = $page * $onPage;
                $limitCount = $onPage * $pageStep;

                $a = StorageBalanceService::Get()->getBalanceMotion(
                $storageNameIDArray,
                $cuser,
                $datefrom,
                $dateto,
                $limitFrom,
                $limitCount
                );

                $this->setValue('motionsArray', $a['result']);

                // степпер
                $stepper = Engine::GetContentDriver()->getContent('shop-admin-logicblock-stepper');
                $stepper->setValue('page', $page);
                $stepper->setValue('onPage', $onPage);
                $stepper->setValue('count', $a['count'] + $page*$onPage);
                $this->setValue('stepper', $stepper->render());

            } catch (ServiceUtils_Exception $se) {
                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $se->getErrorsArray());

                if (PackageLoader::Get()->getMode('debug')) {
                    print $se;
                }
            }
        }

        $storageNames = StorageNameService::Get()->getStorageNamesForTransfers();
        $this->setValue('storageNamesArray', $storageNames->toArray());

        $this->setValue('storagenameSelectedArray', $storageNameIDArray);

        if (empty($datefrom)) {
            $this->setControlValue('datefrom', DateTime_Object::Now()->addMonth(-1)->setFormat('Y-m-d')->__toString());
        }
        if (empty($dateto)) {
            $this->setControlValue('dateto', date('Y-m-d'));
        }
    }

}