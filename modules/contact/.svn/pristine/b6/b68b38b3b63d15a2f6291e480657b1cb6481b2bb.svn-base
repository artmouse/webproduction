<?php
class users_groups_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_UserGroup());

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-users-groups-control', 'key');
        $table->addField($field);

        $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_band_name'));

        $this->setValue('table', $table->render());
    }

}