<?php
class discount_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_Discount());

            $discountID = $this->getArgumentSecure('key');
            if ($discountID)
                $form->denyInsert();

            $this->setValue('form', $form->render($discountID));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }

    }

}