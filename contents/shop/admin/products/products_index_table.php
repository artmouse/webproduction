<?php
class products_index_table extends Engine_Class {

    /**
     * @return DataSource_Products
     */
    private function _getDatasource() {
        return $this->getValue('datasource');
    }

    public function process() {
        $table = new Shop_ContentTable(
            $this->_getDatasource()
        );
        $table->setRow(new Shop_ContentTableRowProducts());

        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-products-edit', 'id');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_code'));
        $table->addField($field);

        $field = new Shop_ContentFieldImage('image');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_image'));
        $table->addField($field);

        $this->setValue('table', $table->render());
    }

}