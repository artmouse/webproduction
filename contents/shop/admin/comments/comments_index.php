<?php
class comments_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_ProductComments());

        $field = new Forms_ContentFieldControlLink('cdate', 'shop-admin-comments-control', 'id');
        $table->addField($field);
        $table->getField('cdate')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_date_time'));

        $this->setValue('table', $table->render());
    }

}