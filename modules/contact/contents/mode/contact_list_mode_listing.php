<?php

class contact_list_mode_listing extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable($this->_getUsers());

        // ссылка на логине
        $field = new Forms_ContentFieldControlLink('login', 'shop-admin-users-control', 'id');
        $table->addField($field);
        $table->getField('login')->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_login')
        );

        // ссылка на ID
        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-users-control', 'id');
        $table->addField($field);
        $table->getField('id')->setName('#');

        // ссылка на имени
        $field = new Forms_ContentFieldControlLink('namelast', 'shop-admin-users-control', 'id');
        $table->addField($field);
        $table->getField('namelast')->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_name_last')
        );

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-users-control', 'id');
        $table->addField($field);
        $table->getField('name')->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_name_small')
        );

        $field = new Forms_ContentFieldControlLink('namemiddle', 'shop-admin-users-control', 'id');
        $table->addField($field);
        $table->getField('namemiddle')->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_name_middle')
        );

        $field = new Forms_ContentFieldControlLink('company', 'shop-admin-users-control', 'id');
        $table->addField($field);
        $table->getField('company')->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_company')
        );

        // прячем поле с паролем
        $table->removeField('password');

        $this->setValue('table', $table->render());
    }
    
    private function _getUsers() {
        return $this->getValue('datasource');
    }
}