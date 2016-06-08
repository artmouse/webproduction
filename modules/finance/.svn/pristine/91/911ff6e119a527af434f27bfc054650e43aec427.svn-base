<?php
class finance_category_control extends Engine_Class {

    public function process() {
        $form = new Forms_ContentForm(new Datasource_FinanceCategory());
        $this->setValue('form', $form->render($this->getArgumentSecure('key')));
    }

}