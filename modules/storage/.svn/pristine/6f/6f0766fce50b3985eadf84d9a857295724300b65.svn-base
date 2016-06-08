<?php
class storage_barcode_print extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();
            try {
                $product = Shop::Get()->getShopService()->getProductByID(
                $this->getControlValue('productid')
                );

                $count = (int)$this->getControlValue('count');

                $this->setValue('product', array(
                'id' => $product->getId(),
                'name' => $product->getName(),
                'count' => $count
                ));

                if (Shop_ModuleLoader::Get()->isImported('document')) {
                    // блок документов
                    $block_documents = Engine::Get()->GetContentDriver()->getContent('shop-admin-document-list-block');
                    $block_documents->setValue('linkkey', $product->getClassname().'-'.$product->getId());
                    $block_documents->setValue('parameterArray', array('count' => $count));
                    $this->setValue('block_documents', $block_documents->render());
                }

            } catch (ServiceUtils_Exception $se) {

            }
        } catch (Exception $e) {

        }


    }

}