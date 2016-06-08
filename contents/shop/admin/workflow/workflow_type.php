<?php
class workflow_type extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_WorkflowType());

        $field = new Forms_ContentFieldControlLink('name', 'shop-workflow-type-edit', 'id');
        $table->addField($field);

        $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title'));

        $this->setValue('table', $table->render());
    }

}