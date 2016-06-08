<?php
class products_storage extends Engine_Class {

    public function process() {
        try {
            $product = Shop::Get()->getShopService()->getProductByID(
            $this->getArgument('id')
            );

            $cuser = $this->getUser();

            $this->setValue('productid', $product->getId());
            $this->setValue('name', $product->getName());
            Engine::GetHTMLHead()->setTitle('Товар #'.$product->getId().' на складе');

            $menu = Engine::GetContentDriver()->getContent('shop-admin-products-menu');
            $menu->setValue('selected', 'storage');
            $this->setValue('menu', $menu->render());

            // остатки
            $balance = StorageBalanceService::Get()->getBalanceByProduct(
            $product,
            $cuser
            );
            $balance->addWhere('amount', 0, '>');

            $storageArray = array();
            $amount_total = 0;
            $amountlinked_total = 0;
            $cost_total = 0;

            while ($x = $balance->getNext()) {
                try {
                    $storageArray[] = array(
                    'storagename' => $x->getStorageName()->getName(),
                    'amount' => $x->getAmount(),
                    'amountlinked' => $x->getAmountlinked(),
                    'cost' => $x->getCost(),
                    'reserveURL' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-storage-reserve', $x->getId(), 'balanceid'),
                    'historyURL' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-storage-motion-balance-history', $x->getId(), 'balanceid')
                    );

                    $amount_total += $x->getAmount();
                    $amountlinked_total += $x->getAmountlinked();
                    $cost_total += $x->getCost();
                } catch (ServiceUtils_Exception $see) {

                }
            }

            $this->setValue('storageArray', $storageArray);

            $totalArray = array(
            'amount' => $amount_total,
            'amountlinked' => $amountlinked_total,
            'cost' => $cost_total
            );

            $this->setValue('totalArray', $totalArray);

            // блок перемещений
            $block_storage = Engine::Get()->GetContentDriver()->getContent('shop-admin-storage-motion-block-list');
            $block_storage->setValue('productid', $product->getId());
            $this->setValue('block_storage_motionlog', $block_storage->render());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}