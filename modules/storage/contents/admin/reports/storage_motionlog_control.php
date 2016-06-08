<?php
class storage_motionlog_control extends Engine_Class {

    public function process() {
        try {
            // разрешены ли склады
            $allowStorage = Engine::Get()->getConfigFieldSecure('storage-status');
            if (!$allowStorage) {
                throw new ServiceUtils_Exception();
            }

            $cuser = $this->getUser();

            $transferID = $this->getArgument('id');
            $transfer = StorageService::Get()->getStorageByID($transferID);

            if (!$cuser->isAllowed('storagename-'.$transfer->getStoragenamefromid().'-read') ||
            !$cuser->isAllowed('storagename-'.$transfer->getStoragenametoid().'-read')) {
                throw new ServiceUtils_Exception();
            }

            $storage = new ShopStorage();
            $products = new ShopProduct();
            $storage->leftJoinTable($products->getTablename(), 'productid='.$products->getTablename().'.id');
            $storage->addWhereQuery($products->getTablename().'.deleted = 0 ');
            $storage->setCdate($transfer->getCdate());
            $storage->setUserid($transfer->getUserid());
            $storage->setStoragenamefromid($transfer->getStoragenamefromid());
            $storage->setStoragenametoid($transfer->getStoragenametoid());
            $storage->setOrderproductid(0);

            if ($this->getControlValue('saveok')) {
                try {
                    $storages = clone $storage;
                    while ($x = $storages->getNext()) {
                        StorageService::Get()->updateTransfer(
                        $x,
                        $this->getUser(),
                        $this->getControlValue('count'.$x->getId()),
                        $this->getControlValue('price'.$x->getId()),
                        $this->getControlValue('currencyid'.$x->getId()),
                        $this->getControlValue('workerid'.$x->getId()),
                        $this->getControlValue('workeroperation'.$x->getId())
                        );
                    }

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

            // валюта по умолчанию
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

            $a = array();
            $sum = 0;
            while ($x = $storage->getNext()) {
                try {
                    $a[] = array(
                    'id' => $x->getId(),
                    'serial' => $x->getSerial(),
                    'price' => $x->getPrice(),
                    'currencyid' => $x->getCurrencyid(),
                    'currency' => $x->getCurrency()->getSymbol(),
                    'count' => $x->getAmount(),
                    'warranty' => $x->getWarranty(),
                    'name' => $x->getProduct()->getName(),
                    'productid' => $x->getProduct()->getId(),
                    'workerid' => $x->getWorkerid(),
                    'workeroperation' => $x->getWorkeroperation()
                    );

                    // считаем сумму с конвертацией
                    $sum += Shop::Get()->getCurrencyService()->convertCurrency(
                    $x->getAmount() * $x->getPrice(),
                    $x->getCurrency(),
                    $currencyDefault
                    );
                } catch (Exception $e) {

                }
            }
            $this->setValue('productsArray', $a);
            $this->setValue('sum', number_format($sum, 2));
            $this->setValue('currency', $currencyDefault->getSymbol());

            $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
            $this->setValue('currencyArray', $currency->toArray());

            $workers = Shop::Get()->getUserService()->getUsersAll();
            $workers->addWhere('name', '', '<>');
            $this->setValue('workersArray', $workers->toArray());

            $this->setValue('productionAllowed', Engine::Get()->getConfigFieldSecure('production-status'));
            $this->setValue('date', $transfer->getCdate());
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}