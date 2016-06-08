<?php
class reserve_cancel_ajax extends Engine_Class {

    public function process() {
        $result = false;
        $status = false;
        $errorsArray = array();

        try {
            $cuser = $this->getUser();

            $orderProductID = $this->getArgument('orderproductid');

            // товар заказа
            $orderProduct = Shop::Get()->getShopService()->getOrderProductById(
            $orderProductID
            );

            // удаляем резерв
            StorageReserveService::Get()->deleteLinksReserve(
            $orderProduct
            );

            // смотрим баланс
            $product = $orderProduct->getProduct();

            $balance = StorageBalanceService::Get()->getBalanceByProductForReserve(
            $product,
            $cuser
            )->getNext();

            $storageArray = array();
            if ($balance) {
                try {
                    $storageArray = array(
                    'id' => $balance->getId(),
                    'name' => $balance->getStorageName()->getName(),
                    'count' => round($balance->getAmountAvailable(), 3)
                    );
                } catch (Exception $balanceEx) {

                }
            }

            $resultArray = array();
            $resultArray['balance'] = $storageArray;

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