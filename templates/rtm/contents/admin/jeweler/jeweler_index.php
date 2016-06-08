<?php
class jeweler_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_Jeweler());

        $field = new Forms_ContentFieldControlLink('name', 'rtm-admin-jeweler-control', 'id');
        $table->addField($field);

        $table->getField('name')->setName(Shop_TranslateFormService::Get()->getTranslate('translate_title'));

        $this->setValue('table', $table->render());
    }

}