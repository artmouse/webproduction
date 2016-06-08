<?php
class storage_passport_ajax_add extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $passport = StorageProductionService::Get()->getProductPassportByID(
            $this->getArgumentSecure('passportid')
            );

            $message = Engine::GetContentDriver()->getContent('shop-admin-storage-passport-message-block');

            // добавляем товар
            if ($this->getControlValue('ok')) {
                try {
                    StorageProductionService::Get()->addProductPassportItem(
                    $passport,
                    $this->getControlValue('productid'),
                    $this->getControlValue('count'),
                    $this->getControlValue('istarget')
                    );

                    $product = Shop::Get()->getShopService()->getProductByID(
                    $this->getControlValue('productid')
                    );

                    $message->setValue('message', 'ok');
                    $message->setValue('id', $product->getId());
                    $message->setValue('name', $product->getName());
                } catch (ServiceUtils_Exception $e) {
                    $message->setValue('message', 'error');
                    $message->setValue('errorsArray', $e->getErrorsArray());
                }
            }

            $block = Engine::GetContentDriver()->getContent('shop-admin-storage-passport-table-block');
            $block->setValue('passportid', $passport->getId());
            $block->setValue('istarget', $this->getControlValue('istarget'));

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