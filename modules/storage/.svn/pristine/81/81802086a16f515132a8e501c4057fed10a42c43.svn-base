<?php
class storage_passport_edit extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        try {
            // получаем паспорт
            $passport = StorageProductionService::Get()->getProductPassportByID(
            $this->getArgument('id')
            );

            // текущий авторизированный пользователь
            $cuser = $this->getUser();

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

            // форма добавления товара-цели
            $block = Engine::GetContentDriver()->getContent('shop-admin-storage-ajax-product-form-block');
            $block->setValue('formID', 'id-form-passport-product-add');
            $parameterArray = array();
            $parameterArray[] = array('name' => 'passportid', 'value' => $passport->getId());
            $parameterArray[] = array('name' => 'istarget', 'value' => true);
            $block->setValue('parameterArray', $parameterArray);
            $this->setValue('addFormProduct', $block->render());
            
            // форма добавления товара-материала
            $block = Engine::GetContentDriver()->getContent('shop-admin-storage-ajax-product-form-block');
            $block->setValue('formID', 'id-form-passport-material-add');
            $parameterArray = array();
            $parameterArray[] = array('name' => 'passportid', 'value' => $passport->getId());
            $block->setValue('parameterArray', $parameterArray);
            $this->setValue('addFormMaterial', $block->render());

            // таблица товаров-целей
            $block = Engine::GetContentDriver()->getContent('shop-admin-storage-passport-table-block');
            $block->setValue('passportid', $passport->getId());
            $block->setValue('istarget', true);
            $this->setValue('productTable', $block->render());
            
            // таблица товаров-материала
            $block = Engine::GetContentDriver()->getContent('shop-admin-storage-passport-table-block');
            $block->setValue('passportid', $passport->getId());
            $block->setValue('istarget', false);
            $this->setValue('materialTable', $block->render());

            $this->setValue('id', $passport->getId());
            $this->setValue('name', $passport->getName());
            $this->setControlValue('name', $passport->getName());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}