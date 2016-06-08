<?php
class link_add extends Engine_Class {

    public function process() {
        $result = false;
        $status = false;
        $errorsArray = array();

        try {
            $cuser = $this->getUser();

            $balanceIDs = $this->getArgument('balanceid');
            $amounts = $this->getArgument('amount');
            
            $basket = StorageService::Get()->getStorageBasketByID(
            $this->getArgument('objectid')
            );

            foreach ($balanceIDs as $k => $balanceID) {
                try {
                    $balance = StorageBalanceService::Get()->getBalanceByID(
                    $balanceID
                    );

                    $storageLink = StorageLinkService::Get()->addLink(
                    $cuser,
                    $balance,
                    $basket,
                    $amounts[$k]
                    );

                } catch (ServiceUtils_Exception $se) {

                }
            }

            $amount = StorageLinkService::Get()->getLinkedProductAmount(
            $cuser,
            $basket
            );

            $resultArray = array();
            $resultArray['amount'] = $amount;

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