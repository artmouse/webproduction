<?php
class storage_reserve extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $balance = StorageBalanceService::Get()->getBalanceByID(
            $this->getArgumentSecure('balanceid')
            );

            if ($this->getArgumentSecure('deletelink')) {
                try {
                    $link = StorageLinkService::Get()->getLinkByID(
                    $this->getArgumentSecure('deletelink')
                    );

                    StorageLinkService::Get()->deleteLink($link, $cuser);
                } catch (Exception $e) {

                }
            }

            $balances = StorageBalanceService::Get()->getBalanceReserveReport(
            $cuser,
            $balance->getStorageName(),
            $balance->getProduct()
            );

            $a = array();

            while ($x = $balances->getNext()) {
                try {
                    // если товар был зарезервирован
                    // находим все привязки
                    $links = StorageLinkService::Get()->getLinksByBalance($x);
                    $linkArray = array();
                    while ($link = $links->getNext()) {
                        $basketType = '';
                        try {
                            $basket = StorageService::Get()->getStorageBasketByID(
                            $link->getBasketid()
                            );

                            $basketType = StorageService::Get()->getTransactionTypeNameByKey($basket->getType());
                        } catch (ServiceUtils_Exception $se) {

                        }

                        $linkArray[] = array(
                        'id' => $link->getId(),
                        'orderid' => $link->getOrderid(),
                        'orderURL' => ($link->getOrderid())?Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-orders-control', $link->getOrderid()):'',
                        'basketType' => $basketType,
                        'amount' => $link->getAmount(),
                        'deleteURL' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('deletelink' => $link->getId()))
                        );
                    }

                    $a[] = array(
                    'id' => $x->getId(),
                    'price' => $x->getPricebase(),
                    'amount' => $x->getAmount(),
                    'amountlinked' => $x->getAmountlinked(),
                    'serial' => $x->getSerial(),
                    'cdate' => $x->getCdate(),
                    'shipment' => $x->getShipment(),
                    'linkArray' => $linkArray
                    );
                } catch (ServiceUtils_Exception $see) {

                }
            }

            $this->setValue('storageName', $balance->getStorageName()->getName());
            $this->setValue('productName', $balance->getProduct()->getName());

            $this->setValue('storageArray', $a);
            $this->setValue('currency', Shop::Get()->getCurrencyService()->getCurrencySystem()->getSymbol());

        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
    }

}