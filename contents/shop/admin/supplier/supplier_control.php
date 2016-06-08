<?php
class supplier_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_Supplier());
            $supplierID = $this->getArgumentSecure('id');
            if ($supplierID) {
                $form->denyInsert();
            }
            $this->setValue('form', $form->render($supplierID));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}