<?php
class payment_control extends Engine_Class {

    public function process() {
        try {
            PackageLoader::Get()->import('CKFinder');

            $form = new Forms_ContentForm(new Datasource_Payment());
            $paymentID = $this->getArgumentSecure('id');
            if ($paymentID) {
                $form->denyInsert();
            }
            $this->setValue('form', $form->render($paymentID));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}