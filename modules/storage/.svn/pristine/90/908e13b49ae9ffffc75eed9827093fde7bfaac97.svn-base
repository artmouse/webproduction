<?php
class storage_stocktaking_table_block extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            // корзина
            $baskets = StorageStocktakingService::Get()->getStocktakingBaskets();

            $basketArray = array();
            while ($basket = $baskets->getNext()) {
                try {
                    $product = $basket->getProduct();

                    $balances = StorageBalanceService::Get()->getBalanceByStorage(
                    $cuser,
                    array($basket->getStoragenamefromid()),
                    array($product->getId()),
                    false
                    );

                    $balanceAmount = 0;
                    $balanceHistoryURL = false;
                    if ($balance = $balances->getNext()) {
                        $balanceAmount = $balance->getAmount();
                        $balanceHistoryURL = Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-storage-motion-balance-history', $balance->getId(), 'balanceid');
                    }

                    $basketArray[] = array(
                    'id' => $basket->getId(),
                    'count' => $basket->getAmount(),
                    'name' => $product->getName(),
                    'productid' => $product->getId(),
                    'unit' => $product->getUnit(),
                    'productURL' => $product->makeURLEdit(),
                    'balance' => $balanceAmount,
                    'diff' => ($basket->getAmount() - $balanceAmount),
                    'balanceHistoryURL' => $balanceHistoryURL
                    );
                } catch (Exception $e) {

                }
            }

            // массив товаров в корзине
            $this->setValue('basketArray', $basketArray);

        } catch (Exception $ge) {

        }
    }

}