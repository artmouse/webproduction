<?php
class linkwindow_index extends Engine_Class {

    public function process() {
        try {
            $this->setValue('windowID', $this->getArgument('windowID'));

            $cuser = $this->getUser();

            $basket = StorageService::Get()->getStorageBasketByID(
            $this->getArgument('objectid')
            );

            $product = $basket->getProduct();

            $links = StorageLinkService::Get()->getLinksByBasket($basket);

            if ($basket->getType() == 'transfer' ||
            $basket->getType() == 'production' ||
            $basket->getType() == 'sale' ||
            $basket->getType() == 'outcoming') {

                $storagename = $basket->getStorageName();

                $balance = StorageBalanceService::Get()->getBalanceByStorageAndProduct(
                $cuser,
                $storagename,
                $product,
                false,
                $basket->getSerial()
                );

            } else {
                throw new ServiceUtils_Exception();
            }

            // массив товаров, которые уже привязаны
            $linkArray = array();
            $sum = 0;

            while ($link = $links->getNext()) {
                $linkArray[] = array(
                'id' => $link->getId(),
                'price' => $link->getBalance()->getPricebase(),
                'amount' => $link->getAmount(),
                'serial' => $link->getSerial(),
                'cdate' => $link->getBalance()->getCdate(),
                'storageName' => $link->getBalance()->getStorageName()->getName(),
                'shipment' => $link->getBalance()->getShipment()
                );

                $sum += $link->getAmount();
            }

            // массив товаров на складе, которые можно привязать
            $productArray = array();
            while ($x = $balance->getNext()) {
                $productArray[] = array(
                'id' => $x->getId(),
                'price' => $x->getPricebase(),
                'amount' => $x->getAmountAvailable(),
                'serial' => $x->getSerial(),
                'cdate' => $x->getCdate(),
                'storageName' => $x->getStorageName()->getName(),
                'shipment' => $x->getShipment()
                );
            }

            $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();

            $this->setValue('currency', $currency->getSymbol());
            $this->setValue('productname', $product->getName());
            $this->setValue('linkArray', $linkArray);
            $this->setValue('productArray', $productArray);
            $this->setValue('linkedAmount', $sum);


        } catch (Exception $e) {
            //print $e;

        }
    }

}