<?php
class banner_control extends Engine_Class {

    public function process() {
        try {
            $ID = $this->getArgumentSecure('id');
            $form = new Forms_ContentForm(new Datasource_Banner($ID));
            if($ID) {
                $this->setValue('edit', 'ok');
                $form->denyInsert();
            }

            $this->setValue('form', $form->render($ID));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }
}