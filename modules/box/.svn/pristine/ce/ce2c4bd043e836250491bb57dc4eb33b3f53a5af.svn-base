<?php
class imap_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_IMAPconfig());
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