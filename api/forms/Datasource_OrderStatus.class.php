<?php

class Datasource_OrderStatus extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getShopService()->getStatusAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-orderstatus-control', 'key');
        $field->setName('#');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_status'));
        $this->addField($field);

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Forms_ContentFieldSelectList('categoryid', true);
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_single_category'));
            $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_OrderCategory'));
            $field->setEmptyOptionValue(0);
            $field->setEmptyOptionName(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_dlya_vseh_kategoriy')
            );
            $this->addField($field);

            $field = new Forms_ContentFieldTextarea('content');
            $field->setName(
                Shop::Get()->getTranslateService()->getTranslateSecure(
                    'translate_rekomendatsii_k_deystviyu_dlya_menedzherov'
                )
            );
            $this->addField($field);
        }

        $field = new Forms_ContentField('logicclass');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_handler'));
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('message');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_email_template'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('messageadmin');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_email_template_admin'));
        $this->addField($field);

        $field = new Forms_ContentField('smslogicclass');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_klassobrabotchik_sms'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('sms');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SMS_template'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('smsadmin');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SMS_template_admin'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('default');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_new_default'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('payed');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_paid'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('saled');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sold'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('downloadable');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_you_can_download_items'));
        $this->addField($field);

        $field = new Forms_ContentFieldInt('sort');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sorting'));
        $this->addField($field);

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Forms_ContentFieldInt('priority');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_prioritet_perekritie'));
            $this->addField($field);
        }

        $field = new Forms_ContentField('colour');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_podsvetka_fona'));
        $this->addField($field);
    }

}