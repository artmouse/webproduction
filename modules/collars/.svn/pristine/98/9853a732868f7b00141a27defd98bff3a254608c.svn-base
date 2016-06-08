<?php
class brands_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_Brands());
            PackageLoader::Get()->import('CKFinder');
            $brandID = $this->getArgumentSecure('id');
            $delete = $this->getArgumentSecure('delete');

            if ($delete) {
                $this->_delete($brandID);
                header('Location: /admin/shop/brands/');
                exit;
            }

            if ($brandID) {
                $form->denyDelete();
            }
            
            $this->setValue('form', $form->render($brandID));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }


    private function _delete ($brandID) {
        try {

            $brand = Shop::Get()->getShopService()->getBrandByID($brandID);
            if ($brand->getProducts()->getCount()) {
                try {
                    SQLObject::TransactionStart();
                    $products = $brand->getProducts();
                    while ($x= $products->getNext()) {
                        $x->setBrandid(0);
                        $x->update();
                    }

                    SQLObject::TransactionCommit();

                } catch (Exception $ge) {
                    SQLObject::TransactionRollback();
                    throw $ge;
                }


            }
            $brand->delete();
            
        } catch (Exception $e) {

        }

    }
}