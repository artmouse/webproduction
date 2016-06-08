<?php
class contactfield_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_ContactField());

            $groupID = $this->getArgumentSecure('key');

            if ($groupID) {
                $form->denyInsert();
            }

            $this->setValue('form', $form->render($groupID));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}