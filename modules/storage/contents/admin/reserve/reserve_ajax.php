<?php
class reserve_ajax extends Engine_Class {

    public function process() {
        $result = false;
        $status = false;
        $errorsArray = array();

        try {
            $cuser = $this->getUser();

            $balanceID = $this->getArgument('balanceid');
            $orderProductID = $this->getArgument('orderproductid');

            // выбранная запись баланса
            $balance = StorageBalanceService::Get()->getBalanceByID(
                $balanceID
            );

            // товар заказа
            $orderProduct = Shop::Get()->getShopService()->getOrderProductById(
                $orderProductID
            );

            StorageReserveService::Get()->addLinksReserve(
                $cuser,
                $balance,
                $orderProduct
            );

            $amount = StorageReserveService::Get()->getProductAmountReserved(
                $cuser,
                $orderProduct
            );

            $storageLinked = array();
            $links = StorageReserveService::Get()->getLinksByOrderProduct($orderProduct);
            while ($link = $links->getNext()) {
                try{
                    $storageName = $link->getStorageName();
                    if (array_key_exists($storageName->getId(), $storageLinked)) {
                        $storageLinked[$storageName->getId()]['amount'] = round(
                            $storageLinked[$storageName->getId()]['amount'] + $link->getAmount(),
                            2
                        );
                    } else {
                        $storageLinked[$storageName->getId()] = array(
                            'storageName' => $storageName->getName(),
                            'balanceid' => $link->getBalance()->getId(),
                            'amount' => round($link->getAmount(), 2)
                        );
                    }

                } catch (Exception $e) {

                }

            }

            $resultArray = array();
            $resultArray['amount'] = $amount;
            $resultArray['storageLinked'] = $storageLinked;
            $resultArray['ok'] = ($amount == $orderProduct->getProductcount());

            $result = $resultArray;
            $status = 'success';
        } catch (Exception $e) {
            $status = 'error';
            $errorsArray = array();
        }

        $json = array(
        'status' => $status,
        'result' => $result,
        'errors' => $errorsArray
        );

        echo json_encode($json);
        exit();
    }

}