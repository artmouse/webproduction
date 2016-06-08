<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class Datasource_Users extends Forms_ADataSourceSQLObject {

    public function __construct($groupID = false) {
        $this->_groupID = $groupID;
    }

    public function setSQLObject($sqlobject) {
        $this->_sqlobject = $sqlobject;
    }

    public function getSQLObject() {
        if ($this->_sqlobject) {
            return $this->_sqlobject;
        }

        $cuser = Shop::Get()->getUserService()->getUser();

        if ($this->_groupID) {
            try {
                $group = Shop::Get()->getUserService()->getUserGroupByID($this->_groupID);
                $users = Shop::Get()->getUserService()->getUsersByGroup($group, $cuser);
            } catch (ServiceUtils_Exception $ge) {
                $users = Shop::Get()->getUserService()->getUsersAll($cuser);
                $users->setId(-1);
            }
        } else {
            $users = Shop::Get()->getUserService()->getUsersAll($cuser);
        }

        $users->setOrder('id', 'DESC');

        $this->_sqlobject = $users;

        return $this->_sqlobject;
    }

    public function getFieldPreview() {
        return $this->getField('id');
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldCheckboxKey('select');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_choice'));
        $field->setSortable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        // gravatar
        $field = new Shop_ContentFieldGravatar('gravatar');
        $field->setName('');
        $field->setSortable(false);
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('namelast');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name_last'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name_small'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('namemiddle');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name_middle'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('company');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_company'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('post');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_post_and_specialization'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('phone');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_telephone'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('employer');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_employee'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('typesex');
        $field->setDataSource(new Datasource_TypeSex());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_typesex'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('email');
        $field->setName('E-mail');
        $field->addValidator(new Forms_ValidatorEmail());
        $field->setQuickedit(true);
        $this->addField($field);

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Forms_ContentField('skype');
            $field->setName('Skype');
            $field->setQuickedit(true);
            $this->addField($field);

            $field = new Forms_ContentField('jabber');
            $field->setName('Jabber');
            $field->setQuickedit(true);
            $this->addField($field);

            $field = new Forms_ContentField('whatsapp');
            $field->setName('WhatsApp');
            $field->setQuickedit(true);
            $this->addField($field);
        }

        $field = new Forms_ContentField('address');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_address'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Shop_ContentFieldUserInfo('managerid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_manager'));
        $field->setDataSource(new Datasource_Users());
        $field->setQuickedit(false);
        $field->setEmptyOptionValue(0);
        $this->addField($field);
        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Shop_ContentFieldUserInfo('parentid');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_recomendation'));
            $field->setDataSource(new Datasource_Users());
            $field->setQuickedit(true);
            $field->setEmptyOptionValue(0);
            $this->addField($field);
        }

        $field = new Forms_ContentFieldDatetime('bdate', 'Y-m-d');
        $field->setEditable(false);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_bdate'));
        $this->addField($field);

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Forms_ContentFieldSelectList('contractorid');
            $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Contractors'));
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_contractor'));
            $field->setEmptyOptionValue(0);
            $field->setQuickedit(true);
            $this->addField($field);
        }

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Forms_ContentFieldSelectList('sourceid');
            $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Source'));
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_istochnik'));
            $field->setQuickedit(true);
            $field->setEmptyOptionValue(0);
            $this->addField($field);

            $field = new Forms_ContentFieldInt('allowreferal');
            $field->setName(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_protsent_referalnie_partnerskie')
            );
            $this->addField($field);
        }

        $field = new Forms_ContentField('login');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_login'));
        $field->addValidator(new Forms_ValidatorLogin());
        $this->addField($field);

        $field = new Forms_ContentFieldPasswordMD5('password', true);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_password'));
        $this->addField($field);

        $field = new Forms_ContentFieldInt('level');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_access_level'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('edate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_edate'));
        $this->addField($field);

        if (!Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Forms_ContentField('time');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_best_time_to_contact'));
            $field->setQuickedit(true);
            $this->addField($field);
        }

        $field = new Forms_ContentFieldTextarea('commentadmin');
        $field->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_comment_hidden_administrator')
        );
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('cdate', 'Y-m-d H:i');
        $field->setEditable(false);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_registration'));
        $this->addField($field);

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Forms_ContentFieldDatetime('activitydate', 'Y-m-d H:i');
            $field->setEditable(false);
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_activity'));
            $this->addField($field);
        }

        $field = new Forms_ContentFieldSelectList('groupid', true);
        $field->setDataSource(new Datasource_UserGroup());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_group'));
        $field->setQuickedit(false);
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentField('tags');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_tags'));
        $field->setQuickedit(false);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('distribution');
        $field->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_subscribe_to_our_newsletter')
        );
        $this->addField($field);

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Shop_ContentFieldUserInfo('authorid');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sozdal'));
            $field->setDataSource(new Datasource_Users());
            $field->setQuickedit(false);
            $field->setEmptyOptionValue(0);
            $this->addField($field);
        }

        $field = new Forms_ContentFieldDatetime('udate', 'Y-m-d H:i');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_obnovlenie'));
        $this->addField($field);
    }

    public function insert($fieldsArray) {
        try {
            SQLObject::TransactionStart();

            $r = parent::insert($fieldsArray);

            try {
                $user = Shop::Get()->getUserService()->getUser();

                $x = Shop::Get()->getUserService()->getUserByID($r);
                $x->setCdate(date('Y-m-d H:i:s'));
                $x->update();

                CommentsAPI::Get()->addComment(
                    'shop-history-user-'.$r,
                    Shop::Get()->getTranslateService()->getTranslateSecure('translate_added_a_new_user').
                    ' #'.$r.' '.$x->getName(),
                    $user->getId()
                );
            } catch (Exception $e) {

            }

            SQLObject::TransactionCommit();

            return $r;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    public function update($key, $fieldsArray) {
        try {
            SQLObject::TransactionStart();

            $r = parent::update($key, $fieldsArray);

            try {
                $user = Shop::Get()->getUserService()->getUser();

                $x = Shop::Get()->getUserService()->getUserByID($key);

                $diffArray = array();
                foreach ($fieldsArray as $field) {
                    if ($field->getEditable()) {
                        $diffArray[] = $field->getName().' '.$field->getValue();
                    }
                }

                CommentsAPI::Get()->addComment(
                    'shop-history-user-'.$x->getId(),
                    Shop::Get()->getTranslateService()->getTranslateSecure('translate_edit_by_user').
                    ' #'.$x->getId().' '.$x->getName()."\n".implode("\n", $diffArray),
                    $user->getId()
                );
            } catch (Exception $e) {

            }

            SQLObject::TransactionCommit();

            return $r;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    public function delete($key) {
        // удалять юзеров нельзя,
        // можно только банить

        try {
            $x = Shop::Get()->getUserService()->getUserByID($key);
            $x->setLevel(0);
            $x->update();

            try {
                $user = Shop::Get()->getUserService()->getUser();

                CommentsAPI::Get()->addComment(
                    'shop-history-user-'.$x->getId(),
                    Shop::Get()->getTranslateService()->getTranslateSecure('translate_blocked_user').
                    ' #'.$x->getId().' '.$x->getLogin(),
                    $user->getId()
                );
            } catch (Exception $e) {

            }
        } catch (Exception $e) {

        }
    }

    private $_groupID = false;
    private $_groupName = false;
    private $_managerName = false;

    private $_sqlobject = false;

}