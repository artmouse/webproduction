<?php
class logo_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_Logo());

            $logoID = $this->getArgumentSecure('key');
            if ($logoID)
                $form->denyInsert();

            $this->setValue('form', $form->render($logoID));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}