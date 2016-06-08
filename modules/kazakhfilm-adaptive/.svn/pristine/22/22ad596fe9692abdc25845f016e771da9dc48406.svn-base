<?php
class Datasource_GuestBook_Kazakh extends Forms_ADataSourceSQLObject {

    /**
     * @return ShopGuestBook
     */
    public function getSQLObject() {
        $x = Shop::Get()->getGuestBookService()->getGuestBookAll();
        $x->setOrder('cdate','DESC');
        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-guestbook-control', 'id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('text');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_reviewed'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('done');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_processeded'));
        $field->setQuickedit(1);
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('cdate');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_created'));
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_name'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('main');
        $field->setQuickedit(1);
        $field->setName('На главную');
        $this->addField($field);

       /* $field = new Forms_ContentFieldFileImage('image');
        $field->setMediaDirectory('/media/shop/');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_image'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('userid', true);
        $field->setDataSource(new Datasource_Users());
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_user_small'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);*/
    }


}
