<?php
class products_passport extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/modules/storage/contents/admin/linkwindow/api2.js');
        PackageLoader::Get()->registerJSFile('/modules/storage/contents/admin/linkwindow/linkwindow.js');
        PackageLoader::Get()->registerJSFile('/modules/storage/contents/admin/ajaxproduct/ajaxproduct.js');
        PackageLoader::Get()->registerJSFile(
            '/modules/storage/contents/admin/ajaxproduct/product_filter_autocomplete.js'
        );

        try {
            $product = Shop::Get()->getShopService()->getProductByID(
                $this->getArgument('id')
            );

            $cuser = $this->getUser();

            $this->setValue('productid', $product->getId());
            $this->setValue('productName', $product->getName());
            Engine::GetHTMLHead()->setTitle('Товар #'.$product->getId().' на складе');

            $menu = Engine::GetContentDriver()->getContent('shop-admin-products-menu');
            $menu->setValue('selected', 'storagePassport');
            $this->setValue('menu', $menu->render());


            // получаем паспорт

            $passport = new ShopProductPassport();
            $passport->setDefault($product->getId());
            $passport = $passport->getNext();

            if (!$passport) {
                $passport = new ShopProductPassport();
                $passport->setDefault($product->getId());
                $passport->setValid(1);
                $passport->setName($product->getName());
                $passport->insert();

            }

            $passportItem = new XShopProductPassportItem();
            $passportItem->setPassportid($passport->getId());
            $passportItem->setProductid($product->getId());
            $passportItem->setIstarget(1);
            $passportItem = $passportItem->getNext();

            if (!$passportItem) {
                $passportItem = new XShopProductPassportItem();
                $passportItem->setPassportid($passport->getId());
                $passportItem->setProductid($product->getId());
                $passportItem->setIstarget(1);
                $passportItem->setAmount(1);
                $passportItem->insert();
            }

            if ($this->getControlValue('ok')) {
                try {
                    // обновляем информацию
                    StorageProductionService::Get()->updateProductPassport(
                        $passport,
                        $this->getControlValue('name')
                    );

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $te) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $te;
                    }

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $te->getErrorsArray());
                }
            }

            // форма добавления товара-материала
            $block = Engine::GetContentDriver()->getContent('shop-admin-storage-ajax-product-form-block');
            $block->setValue('formID', 'id-form-passport-material-add');
            $parameterArray = array();
            $parameterArray[] = array('name' => 'passportid', 'value' => $passport->getId());
            $block->setValue('parameterArray', $parameterArray);
            $this->setValue('addFormMaterial', $block->render());

            // таблица товаров-материала
            $block = Engine::GetContentDriver()->getContent('shop-admin-storage-passport-table-block');
            $block->setValue('passportid', $passport->getId());
            $block->setValue('istarget', false);
            $this->setValue('materialTable', $block->render());

            $this->setValue('id', $passport->getId());
            $this->setValue('name', $passport->getName());
            $this->setControlValue('name', $passport->getName());
            $this->setValue('productCount', $passportItem->getAmount());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}