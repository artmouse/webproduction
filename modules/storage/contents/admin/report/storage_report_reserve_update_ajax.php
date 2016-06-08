<?php
class storage_report_reserve_update_ajax extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $storagenameid = $this->getArgumentSecure('storagenameid');
            $productid = $this->getArgumentSecure('productid');

            // обновить мин резерв
            try {
                $amount = $this->getArgument('amount');

                $rrc = 0;
                $currencyID = 0;

                try {
                    $x = StorageBalanceService::Get()->getStorageReserve(
                    $storagenameid,
                    $productid
                    );

                    $rrc = $x->getRrc();
                    $currencyID = $x->getCurrencyid();
                } catch (ServiceUtils_Exception $re) {

                }

                $reserve = StorageBalanceService::Get()->updateStorageReserve(
                $storagenameid,
                $productid,
                $amount,
                $rrc,
                $currencyID
                );
            } catch (Exception $ee) {

            }

            // обновить мин резерв
            try {
                $rrc = $this->getArgument('rrc');
                $currencyID = $this->getArgument('currencyid');

                $amount = 0;

                try {
                    $x = StorageBalanceService::Get()->getStorageReserve(
                    $storagenameid,
                    $productid
                    );

                    $amount = $x->getAmount();
                } catch (ServiceUtils_Exception $re) {

                }

                $reserve = StorageBalanceService::Get()->updateStorageReserve(
                $storagenameid,
                $productid,
                $amount,
                $rrc,
                $currencyID
                );
            } catch (Exception $ee) {

            }

            // получить баланс
            $balances = StorageBalanceService::Get()->getBalanceByStorage(
            $cuser,
            array($storagenameid),
            array($productid),
            false
            );

            $percent = 0;
            if ($balance = $balances->getNext()) {
                if ($reserve->getAmount() > 0) {
                    $percent = $balance->getAmount() * 100 / $reserve->getAmount();
                } else {
                    $percent = 0;
                }
            }

            $currencyName = '';
            try {
                $currencyName = $reserve->getCurrency()->getSymbol();
            } catch (ServiceUtils_Exception $ce) {

            }

            echo json_encode(array(
            'amount' => number_format($reserve->getAmount(), 3),
            'percent' => round($percent),
            'rrc' => $reserve->getRrc(),
            'currency' => $currencyName,
            'currencyid' => $reserve->getCurrencyid()
            ));
            exit;
        } catch (Exception $e) {
            echo json_encode(array('error'));
            exit;
        }
    }

}