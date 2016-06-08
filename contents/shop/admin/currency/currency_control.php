<?php
class currency_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_Currency());

            $form->denyDelete();
            $form->denyUpdate();
            $form->getField('default')->setEditable(false);
            $form->getField('name')->setEditable(true);
            $form->getField('name')->setName(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_currency_small')
            );

            $this->setValue('form', $form->render());
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}