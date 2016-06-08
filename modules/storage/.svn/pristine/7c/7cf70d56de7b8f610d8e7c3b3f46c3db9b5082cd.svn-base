<?php
class storage_sale extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            // провести отгрузку
            if ($this->getControlValue('process')) {
                try {
                    try {
                        $order = Shop::Get()->getShopService()->getOrderByID(
                        $this->getControlValue('orderid')
                        );
                    } catch (ServiceUtils_Exception $sse) {
                        throw new ServiceUtils_Exception('order');
                    }

                    $storageID = StorageSaleService::Get()->processSale(
                    $cuser,
                    $this->getControlValue('date')
                    );

                    if ($storageID) {
                        $this->setValue('messageprocess', 'ok');
                        
                        // если товары были отгружены, редиректимся
                        // на страницу просмотра продажи
                        $this->setValue('urlredirect',
                        Engine::GetLinkMaker()->makeURLByContentIDParam(
                        'shop-admin-storage-motion-view',
                        $storageID
                        ));
                    } else {
                        $this->setValue('messageinfo', 'nosale');
                    }
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('messageprocess', 'error');

                    $errorArray = array();
                    $exArray = $e->getErrorsArray();

                    foreach ($exArray as $error) {
                        if (preg_match("/^(\d+):(\w+)$/uis", $error, $r)) {
                            try {
                                $basket = StorageService::Get()->getStorageBasketByID($r[1]);
                                $product = $basket->getProduct();

                                $errorArray[] = array(
                                'product' => '#'.$product->getId().' - '.$product->getName().' ('.$basket->getAmount().' '.$product->getUnit().')',
                                'error' => $r[2]
                                );
                            } catch (ServiceUtils_Exception $re) {}
                        } else {
                            $errorArray[] = array(
                            'error' => $error
                            );
                        }
                    }

                    $this->setValue('errorsArray', $errorArray);

                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
            }

            // отменить отгрузку
            if ($this->getControlValue('clear')) {
                try {
                    StorageSaleService::Get()->clearSales($cuser);
                } catch (ServiceUtils_Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
            }

            // корзина накладной
            $sales = StorageSaleService::Get()->getSalesByUser(
            $cuser
            );

            $sales_test = clone $sales;

            $storageName = false;

            if ($sale_test = $sales_test->getNext()) {
                try {
                    $order = false;

                    // список товаров
                    $basketArray = array();

                    while ($sale = $sales->getNext()) {
                        try {
                            $order = Shop::Get()->getShopService()->getOrderByID($sale->getOrderid());
                            $product = $sale->getProduct();
                            $storageName = $sale->getStorageName();

                            $basketArray[] = array(
                            'id' => $sale->getId(),
                            'count' => $sale->getAmount(),
                            'name' => $product->getName(),
                            'productid' => $product->getId(),
                            'linkedAmount' => StorageLinkService::Get()->getLinkedProductAmount($cuser, $sale)
                            );
                        } catch (Exception $e) {

                        }
                    }

                    if (!$order || !$storageName) {
                        throw new ServiceUtils_Exception();
                    }

                    $this->setValue('productsArray', $basketArray);
                    $this->setValue('orderid', $order->getId());
                    $this->setValue('orderSum', $order->getSum());
                    $this->setValue('orderCurrency', $order->getCurrency()->getName());
                    
                    $this->setValue('storagefromname', $storageName->getName());

                    try {
                        $this->setValue('orderClientName', $order->getUser()->makeName());
                    } catch (Exception $clientEx) {
                        $this->setValue('orderClientName', $order->getClientname());
                    }
                    
                    $this->setControlValue('date', date('Y-m-d H:i:s'));

                } catch (ServiceUtils_Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
            } else {
                $datasource = new Datasource_OrdersForShipment();
                if ($this->getControlValue('orderid')) {
                    $datasource->getSQLObject()->setId($this->getControlValue('orderid'));
                }
                
                // таблица заказов
                $table = new Shop_ContentTable($datasource);
                $table->setRow(new Shop_ContentTableRowOrders());
                $table->setLinesOnPage(10);
                $this->setValue('table', $table->render());
            }

        } catch (Exception $ee) {

        }
    }

}