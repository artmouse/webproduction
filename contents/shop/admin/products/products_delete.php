<?php
class products_delete extends Engine_Class {

    public function process() {
        try {
            $product = Shop::Get()->getShopService()->getProductByID(
                $this->getArgument('id')
            );

            $this->setValue('productid', $product->getId());
            $this->setValue('name', htmlspecialchars($product->getName()));

            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_udalenie_tovara_').$product->getId()
            );

            if ($this->getControlValue('ok')) {
                try {
                    Shop::Get()->getShopService()->deleteProduct($product);

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

            if ($this->getControlValue('okdeleted')) {
                try {
                    $product->setDeleted(1);
                    $product->update();

                    $this->setValue('message', 'okdeleted');
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-products-menu');
            $menu->setValue('selected', 'delete');
            $this->setValue('menu', $menu->render());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}