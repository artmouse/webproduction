<?php

class Datasource_TextPage extends Datasource_TextPages {

    public function notify(Events_Event $event) {
        $datasource = $event->getObject();

        $field = new Forms_ContentField('url');
        $field->setEditable(true);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_URL_prefix'));
        $field->addValidator(new Forms_ValidatorSubUrl());
        $field->addValidator(new Shop_ValidatorURLUnique());
        $datasource->addField($field);

    }




}