<?php
class timework_control extends Engine_Class {

    public function process() {
        try {
            PackageLoader::Get()->import('CKFinder');

            $form = new Forms_ContentForm(new Datasource_TimeWork());

            $timeworkID = $this->getArgumentSecure('key');
            if ($timeworkID)
                $form->denyInsert();

            $this->setValue('form', $form->render($timeworkID));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }

    }

}