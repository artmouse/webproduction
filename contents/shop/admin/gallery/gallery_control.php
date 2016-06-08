<?php
class gallery_control extends Engine_Class {

    public function process() {
        PackageLoader::Get()->import('CKFinder');
        try {
            $form = new Forms_ContentForm(new Datasource_Gallery());
            $key = $this->getArgumentSecure('key');
            if ($key) {
                $form->denyInsert();
            }
            $this->setValue('form', $form->render($key));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}