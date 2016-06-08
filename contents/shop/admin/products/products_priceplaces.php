<?php
class products_priceplaces extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        try {
            $product = Shop::Get()->getShopService()->getProductByID(
                $this->getArgument('id')
            );

            $this->setValue('productid', $product->getId());
            $this->setValue('name', $product->getName());
            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_tovar_').$product->getId()
            );

            if ($this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();

                    $ppArray = $this->getArgumentSecure('pp');
                    if (!$ppArray) {
                        $ppArray = array();
                    }

                    // удаляем все связи
                    $tmp = new XShopExportPlaceCategory();
                    $tmp->setProductid($product->getId());
                    while ($x = $tmp->getNext()) {
                        $x->delete();
                    }

                    // добавляем связи
                    foreach ($ppArray as $ppID) {
                        $tmp = new XShopExportPlaceCategory();
                        $tmp->setProductid($product->getId());
                        $tmp->setPlaceid($ppID);
                        $tmp->insert();
                    }

                    SQLObject::TransactionCommit();

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $e) {
                    SQLObject::TransactionRollback();
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

            $pp = new XShopExportPlace();
            $pp->setOrder('name');
            $a = array();
            while ($x = $pp->getNext()) {
                $selected = false;
                $tmp = new XShopExportPlaceCategory();
                $tmp->setPlaceid($x->getId());
                $tmp->setProductid($product->getId());
                $selected = $tmp->select();

                $a[] = array(
                'name' => $x->getName(),
                'id' => $x->getId(),
                'selected' => $selected,
                );
            }
            $this->setValue('ppArray', $a);

            $menu = Engine::GetContentDriver()->getContent('shop-admin-products-menu');
            $menu->setValue('selected', 'priceplaces');
            $this->setValue('menu', $menu->render());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}