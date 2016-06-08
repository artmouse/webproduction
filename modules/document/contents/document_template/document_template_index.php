<?php
class document_template_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_DocumentTemplate());

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-document-templates-control', 'id');
        $table->addField($field);

        $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title_of_document'));

        $this->setValue('table', $table->render());
    }

}