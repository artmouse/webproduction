<?php
class storage_basket_block_import extends Engine_Class {

    public function process() {
        if ($this->getArgumentSecure('import_file')) {
            try {
                $ex = new ServiceUtils_Exception();

                // получаем файл
                $file = $this->getControlValue('file');
                $file = @$file['tmp_name'];

                if (!file_exists($file)) {
                    $ex->addError('file');
                }

                // читаем прайс
                PackageLoader::Get()->import('XLS');

                $data = new XLS_Reader();
                $data->setOutputEncoding('UTF-8');
                $data->read($file);

                $encoding = $this->getControlValue('encoding');

                // первая строка
                $columnArray = $data->sheets[0]['cells'][1];

                // ищем номера колонок
                $columnId = array_search('productid', $columnArray);
                $columnName = array_search('productname', $columnArray);
                $columnPrice = array_search('price', $columnArray);
                $columnCurrency = array_search('currency', $columnArray);
                $columnWarranty  = array_search('warranty', $columnArray);
                $columnSerial  = array_search('serial', $columnArray);
                $columnShipment = array_search('shipment', $columnArray);
                $columnTax = array_search('tax', $columnArray);
                $columnCount = array_search('count', $columnArray);

                // если нету Id и Name выходим
                if (!$columnId && !$columnName) {
                    $ex->addError('noProduct');
                }

                if ($ex->getErrorsArray()) {
                    throw $ex;
                }

                $cuser = $this->getUser();

                $from = 2;
                $to = $data->sheets[0]['numRows'];

                for ($i = $from; $i <= $to; $i++) {
                    try{
                        $count = @trim($data->sheets[0]['cells'][$i][$columnCount]);
                        $price = @trim($data->sheets[0]['cells'][$i][$columnPrice]);
                        $price = str_replace(',', '.', $price);
                        $code = @trim($data->sheets[0]['cells'][$i][$columnId]);
                        $code = preg_replace("/[^a-zA-ZА-Яа-я0-9\s]/", "", $code);
                        $name = @trim($data->sheets[0]['cells'][$i][$columnName]);
                        $currency = @trim($data->sheets[0]['cells'][$i][$columnCurrency]);
                        $warranty = @trim($data->sheets[0]['cells'][$i][$columnWarranty]);
                        $serial = @trim($data->sheets[0]['cells'][$i][$columnSerial]);
                        $shipment = @trim($data->sheets[0]['cells'][$i][$columnShipment]);
                        $tax = @trim($data->sheets[0]['cells'][$i][$columnTax]);

                        if ($encoding == 'windows-1251') {
                            $name = mb_convert_encoding($name, "UTF-8", "windows-1251");
                        }

                        if (!$name && !$code) {
                            continue;
                        }

                        try{
                            $product = Shop::Get()->getShopService()->getProductByID($code);
                        } catch (ServiceUtils_Exception $se) {
                            $product = Shop::Get()->getShopService()->addProduct($name);
                        }

                        StorageBasketService::Get()->addStorageBasketFromXLS(
                            $cuser,
                            $product,
                            $price,
                            $count,
                            $currency,
                            $warranty,
                            $serial,
                            $shipment,
                            $tax
                        );

                    } catch (Exception $eeny) {

                    }

                }

                $this->setValue('message', 'ok');

            } catch (ServiceUtils_Exception $e) {
                $this->setValue('message', 'error');
                $this->setValue('errorArray', $e->getErrorsArray());
            } catch (Exception $e) {
                $this->setValue('message', 'error');
            }
        }
    }

}