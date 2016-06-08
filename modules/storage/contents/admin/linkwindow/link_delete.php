<?php
class link_delete extends Engine_Class {

    public function process() {
        $result = false;
        $status = false;
        $errorsArray = array();

        try {
            $cuser = $this->getUser();
            
            $link = StorageLinkService::Get()->getLinkByID(
            $this->getArgument('linkid')
            );

            $basket = $link->getBasket();

            StorageLinkService::Get()->deleteLink($link, $cuser);

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