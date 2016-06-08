<?php

class status_import extends Engine_Class {

    public function process() {

        $resaltArray = array();
        $isDisplayProcessed = $this->getValue('processed');
        $importStatus = new XPriceSupplierImportStatus();
        $importStatus->setOrder('dateupload', 'DESC');

        while ($status = $importStatus->getNext()) {

            $id = $status->getId();
            $prid = $status->getPriceid();
            $dateUpload = $status->getDateupload();

            // пропустить загруженные но не подтвержденные
            $confirm = $this->_checkUploadConfirm($dateUpload);

            // если файла нет убираем кнопку "скачать"
            $notEmpty = false;
            if ($status->getPricenamemd5()) {
                $notEmpty = true;
            }

            if (!$confirm) {
                continue;
            }

            try {               
                $supplier = Shop::Get()->getShopService()->getSupplierByID($status->getSupplierid());
                $processed = $status->getProcessed();
                $dateProcessed = $status->getDateprocessed();
                $resultSuccess = $status->getResultsuccess();
                $resultAdded = $status->getResultadded();
                $resultFail = $status->getResultfail();
                $urlPrint = Engine::GetLinkMaker()->makeURLByContentIDParam(
                    'shop-admin-supplier-import-status-print',
                    $status->getId()
                );
                if ($processed && $isDisplayProcessed) {
                    continue;
                }
                if (!$processed && !$isDisplayProcessed) {
                    continue;
                }

                $a['id'] = $id;
                $a['priceid'] = $prid;
                $a['dateUpload'] = $dateUpload;
                $a['supplier'] = $supplier->getName();
                $a['processStatus'] = $processed;
                $a['dateProcessed'] = $dateProcessed;
                $a['resultSuccess'] = $resultSuccess;
                $a['resultAdded'] = $resultAdded;
                $a['resultFail'] = $resultFail;
                $a['urlPrint'] = $urlPrint;
                $a['notEmpty'] = $notEmpty;
                $resaltArray[] = $a;
            } catch (Exception $e) {
                
            }
        }

        $this->setValue('resaltArray', $resaltArray);

        // если нажали "скачать"
        if ($this->getArgumentSecure('priceid')) {

            $curPrice = new XPriceSupplierImportStatus($this->getArgumentSecure('priceid'));
            $fileName = $curPrice->getPricenamemd5();
            $filePath = PackageLoader::Get()->getProjectPath() . "/media/import/" . $fileName;

            if (preg_match('/[a-z0-9+]\.([a-z]+)/ius', $fileName, $r)) {
                $format = $r[1];
            } else {
                exit;
            }
            $newName = 'Прайслист-' . $this->getArgumentSecure('priceid');
            $this->_send($newName, $format);
            $content = file_get_contents($filePath);
            print $content;
            exit;
        }
    }

    /**
     *  Проверить подтверждена ли запись импорта
     * @param string $date дата загрузки
     */
    private function _checkUploadConfirm($date) {

        $priceImport = new XShopPriceSupplierImport();
        $priceImport->filterCdate($date);
        $priceImport->filterLastpart(1);

        if (!$priceImport->select()) {
            return false;
        }

        if ($priceImport->getCdate() == $priceImport->getPdate()) {
            return false;
        }

        return true;
    }

    // отправка http заголовков
    private function _send($filename, $format) {
        if ($format == 'xls' || $format == 'xlsx') {
            header("Content-type: application/vnd.ms-excel");
        } elseif ($format == 'csv') {
            header("Content-type: text/csv");
        } else {
            return false;
        }
        header("Content-Encoding: windows-1251");
        header("Content-Disposition: attachment; filename=\"$filename\.$format\"");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Pragma: public");
    }

}