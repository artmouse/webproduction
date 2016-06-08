<?php
class storage_production_ajax_add extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $message = Engine::GetContentDriver()->getContent('shop-admin-storage-production-message-block');

            // добавляем в корзину перемещения товар
            if ($this->getControlValue('ok')) {
                try {
                    StorageProductionService::Get()->addPassportToProduction(
                    $cuser,
                    $this->getControlValue('storagefromid'),
                    $this->getControlValue('productid'),
                    $this->getControlValue('count')
                    );

                    $passport = StorageProductionService::Get()->getProductPassportByID(
                    $this->getControlValue('productid')
                    );

                    $message->setValue('message', 'ok');
                    $message->setValue('id', $passport->getId());
                    $message->setValue('name', $passport->getName());
                } catch (ServiceUtils_Exception $e) {
                    $message->setValue('message', 'error');
                    $message->setValue('errorsArray', $e->getErrorsArray());
                }
            }

            $block_content_products = Engine::GetContentDriver()->getContent(
            'shop-admin-storage-production-table-block'
            );
            $block_content_products->setValue('istarget', true);
            $block_content_products = $block_content_products->render();
            
            $block_content_materials = Engine::GetContentDriver()->getContent(
            'shop-admin-storage-production-table-block'
            );
            $block_content_materials->setValue('istarget', false);
            $block_content_materials = $block_content_materials->render();
            
            $block_content_passports = Engine::GetContentDriver()->getContent(
            'shop-admin-storage-production-passport-table-block'
            );
            $block_content_passports = $block_content_passports->render();

            print json_encode(array(
            'content_products' => $block_content_products,
            'content_materials' => $block_content_materials,
            'content_passports' => $block_content_passports,
            'message' => $message->render()
            ));
            exit();

        } catch (Exception $e) {
            print $e;
            echo json_encode(array('error' => 'error'));
            exit();
        }
    }

}