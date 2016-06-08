<?php

class ajax_supplier_import_prew extends Engine_Class {

    public function process() {
        // Обработка
        try {
            $file = $this->getControlValue('file');
            $type = $this->getControlValue('fileType');
            $fileEncoding = $this->getControlValue('fileType');
            $dataArray = array();
            // Результат роботы конвертера
            $convertFile = false;
            $textType = false;
            if ($type == 'xls' || $type == 'xlsx') {
                $file = @$file['tmp_name'];
                $ex = new ServiceUtils_Exception();
                if (!file_exists($file)) {
                    $ex->addError('file');
                    throw $ex;
                }

                if ($type == 'xlsx') {
                    $mediaFile = md5(file_get_contents($file) . 'prew') . '.xlsx';
                } elseif ($type == 'xls') {
                    $mediaFile = md5(file_get_contents($file) . 'prew') . '.xls';
                }

                copy($file, PackageLoader::Get()->getProjectPath() . 'media/import/' . $mediaFile);

                // пробуем конвертировать в csv
                // Конвертер возвращает 0 при успешном конверте
                $result = Shop::Get()->getSupplierService()->convertXLStoCSV($mediaFile);
                if ((int) $result === 0) {
                    $convertFile = true;
                    $csv = PackageLoader::Get()->getProjectPath() . 'media/import/csv/Sheet1.csv';
                    $type = 'csv-comma';
                    $mediaFile = md5(file_get_contents($csv)) . '.csv';
                    copy($csv, PackageLoader::Get()->getProjectPath() . 'media/import/' . $mediaFile);
                }
            } elseif ($type == 'csv-default' || $type == 'csv-comma' || $type == 'csv-tab') {
                $textType = true;
                $file = @$file['tmp_name'];
                $mediaFile = md5(file_get_contents($file)) . '.csv';
                copy($file, PackageLoader::Get()->getProjectPath() . 'media/import/' . $mediaFile);
            }
            // Обрабатываем
            if (!$convertFile && !$textType) {
                // Не сработал, обрабатываем xls
                PackageLoader::Get()->import('XLS');
                $data = new XLS_Reader();
                $data->setOutputEncoding('UTF-8');
                $data->read($file);
                for ($i = 1; $i <= 10; $i++) {
                    if (key_exists($i, $data->sheets[0]['cells'])) {
                        // Xls reader в случае пустоты ячейки не пишет ее в массив
                        // нам же пустые также нужны, пишем вручную
                        $rowArray = $data->sheets[0]['cells'][$i];
                        end($rowArray);
                        $countColumn = key($rowArray);
                        reset($rowArray);
                        for ($j = 1; $j <= $countColumn; $j++) {
                            if (!key_exists($j, $rowArray)) {
                                $rowArray[$j] = '';
                            }
                        }
                        ksort($rowArray);
                        $dataArray[$i] = $rowArray;
                    }
                }
            } elseif ($textType || $convertFile) {
                // Сработал или изначально имел текстовый тип
                $delimeter = ';';
                if ($type == 'csv-comma') {
                    $delimeter = ',';
                }
                if ($type == 'csv-tab') {
                    $delimeter = "\t";
                }
                if ($fileEncoding == 'windows-1251') {
                    setlocale(LC_ALL, 'ru_RU.CP1251');
                }
                $file = PackageLoader::Get()->getProjectPath() . 'media/import/' . $mediaFile;
                $f = fopen($file, 'r');
                $lineIndex = 0;
                while ($line = fgetcsv($f, 4096, $delimeter)) {
                    $dataArray[$lineIndex] = $line;
                    $lineIndex ++;
                    if ($lineIndex >= 10) {
                        break;
                    }
                }
            }
            @unlink(PackageLoader::Get()->getProjectPath() . 'media/import/' . $mediaFile);
        } catch (Exception $e) {
            
        }

        if ($dataArray) {
            $prewTable = Engine::GetContentDriver()->getContent('shop-admin-supplier-import-prew');
            $prewTable->setValue('dataArray', $dataArray);
            echo $prewTable->render();
        }
        
        exit();
    }

}