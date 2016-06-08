<?php
class storage_sale_ajax_add extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $message = Engine::GetContentDriver()->getContent('shop-admin-storage-sale-message-block');

            // добавляем в корзину перемещения товар
            if ($this->getControlValue('ok')) {
                try {
                    $basket = StorageSaleService::Get()->addSaleQuick(
                    $cuser,
                    $this->getControlValue('storagefromid'),
                    $this->getControlValue('productid'),
                    $this->getControlValue('count'),
                    $this->getControlValue('price'),
                    $this->getControlValue('currencyid')
                    );

                    if ($this->getControlValue('balanceid')) {
                        try {
                            $balance = StorageBalanceService::Get()->getBalanceByID(
                            $this->getControlValue('balanceid')
                            );
                            
                            $storageLink = StorageLinkService::Get()->addLink(
                            $cuser,
                            $balance,
                            $basket,
                            $basket->getAmount()
                            );
                        } catch (ServiceUtils_Exception $de) {

                        }
                    }

                    $product = Shop::Get()->getShopService()->getProductByID(
                    $this->getControlValue('productid')
                    );

                    $message->setValue('message', 'ok');
                    $message->setValue('id', $product->getId());
                    $message->setValue('name', $product->getName());
                } catch (ServiceUtils_Exception $se) {

                    $message->setValue('message', 'error');
                    $message->setValue('errorsArray', $se->getErrorsArray());
                }
            }

            $block = Engine::GetContentDriver()->getContent('shop-admin-storage-sale-table-block');

            print json_encode(array(
            'content' => $block->render(),
            'message' => $message->render()
            ));
            exit();

        } catch (Exception $e) {
            echo json_encode(array('error' => 'error'));
            exit();
        }
    }

}