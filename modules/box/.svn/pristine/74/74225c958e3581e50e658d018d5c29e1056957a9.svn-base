<?php
class admin_search_block_product extends Engine_Class {

    public function process() {
        try {
            $query = $this->getValue('query');
            $limit = $this->getValue('limit');

            // поиск на складе
            if (Shop_ModuleLoader::Get()->isImported('storage')) {
                $cuser = $this->getUser();
                $balances = StorageBalanceService::Get()->getBalanceBySerial($cuser, $query);

                $storageArray = array();
                while ($balance = $balances->getNext()) {
                    try {
                        $product = $balance->getProduct();

                        $storageArray[] = array(
                        'serial' => $balance->getSerial(),
                        'name' => $product->getName(),
                        'url' => $product->makeURLEdit(),
                        'image' => $product->makeImageThumb(100, 100),
                        'price' => $balance->getPricebase(),
                        'date' => $balance->getCdate(),
                        'amount' => $balance->getAmountAvailable(),
                        'storageName' => $balance->getStorageName()->getName(),
                        'storageURL' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-storage-balance', $balance->getStoragenameid(), 'storagenameid[]'),
                        'historyURL' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-storage-motion-balance-history', $balance->getId(), 'balanceid'),
                        );
                    } catch (ServiceUtils_Exception $se) {

                    }
                }

                $this->setValue('storageArray', $storageArray);
            }

            $products = Shop::Get()->getShopService()->searchProducts($query, false);
            $products->unsetField('hidden');
            $products->unsetField('deleted');
            $products->setLimitCount($limit);
            //$products->setOrder('`deleted` ASC, `hidden` ASC, `avail` DESC, `relevance` DESC', false);

            $productArray = array();
            while ($product = $products->getNext()) {
                $currencyName = '';
                try {
                    $currencyName = $product->getCurrency()->getSymbol();
                } catch (ServiceUtils_Exception $se) {

                }

                $productArray[] = array(
                'id' => $product->getId(),
                'name' => $product->makeName(),
                'url' => $product->makeURLEdit(),
                'image' => $product->makeImageThumb(100, 100),
                'hidden' => ($product->getHidden() || $product->getDeleted()),
                'price' => $product->getPrice(),
                'pricebase' => $product->getPricebase(),
                'currency' => $currencyName,
                'avail' => ($product->getAvail() > 0)
                );
            }

            $this->setValue('productArray', $productArray);
        } catch (Exception $e) {

        }

    }

}