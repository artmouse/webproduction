<?php
class callback_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_Callback());
            PackageLoader::Get()->import('CKFinder');
            $ID = $this->getArgumentSecure('id');
            try {
                Shop::Get()->getFeedbackService()->getFeedbackByID($ID);
            } catch (Exception $e) {

            }
            $form->denyInsert();

            $this->setValue('form', $form->render($ID));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}