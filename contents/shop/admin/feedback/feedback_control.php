<?php
class feedback_control extends Engine_Class {

    public function process() {
        try {
            PackageLoader::Get()->import('CKFinder');

            $form = new Forms_ContentForm(new Datasource_Feedback());
            $form->denyInsert();

            $this->setValue('form', $form->render($this->getArgumentSecure('id')));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }

    }

}