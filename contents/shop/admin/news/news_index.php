<?php
class news_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_News());

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-news-control', 'id');
        $table->addField($field);

        $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_piece_of_news'));

        $this->setValue('table', $table->render());
    }

}