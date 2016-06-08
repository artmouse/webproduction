<?php
class brands_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_Brands());
            PackageLoader::Get()->import('CKFinder');
            $brandID = $this->getArgumentSecure('id');
            if ($brandID) {
                $form->denyInsert();
            }
            try {
                $brand = Shop::Get()->getShopService()->getBrandByID($brandID);

                if ($brand->getProducts()->getCount()) {
                    $form->denyDelete();
                }
            } catch (Exception $e) {

            }

            $this->setValue('form', $form->render($brandID));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}