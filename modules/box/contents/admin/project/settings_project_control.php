<?php
class settings_project_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_Project());

            $id = $this->getArgumentSecure('key');
            if ($id) {
                $form->denyInsert();
            }

            $this->setValue('form', $form->render($id));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}