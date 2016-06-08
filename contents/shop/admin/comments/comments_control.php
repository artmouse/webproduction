<?php
class comments_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_ProductComments());
            $id = $this->getArgumentSecure('id');
            if ($id)
                $form->denyInsert();
            $this->setValue('form', $form->render($id));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }

    }

}