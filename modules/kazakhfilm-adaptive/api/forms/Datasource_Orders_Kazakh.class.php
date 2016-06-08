<?php
class Datasource_Orders_Kazakh extends Forms_ADataSourceSQLObject {

    /**
     * @return ShopOrder
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $orders = Shop::Get()->getShopService()->getOrdersAll();
            $cuser = Shop::Get()->getUserService()->getUser();

            if ($cuser->getLevel() < 3) {
                $status = Shop::Get()->getShopService()->getUsersOrderStatusArray('view');
                $statusIDs = array(-1);
                foreach ($status as $s) {
                    $statusIDs[] = $s['id'];
                }
                $orders->addWhereQuery('(`statusid` IN ('.implode(', ', $statusIDs).'))');

                $categoryIDArray = Shop::Get()->getShopService()->getOrderCategoryIDArrayByUser($cuser);
                $orders->addWhereQuery('(`categoryid` IN ('.implode(', ', $categoryIDArray).'))');
            }

            $this->_sqlobject = $orders;
        }
        return $this->_sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldCheckboxKey('select');
        $field->setName('#');
        $field->setSortable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentFieldControlLink('cdate', 'shop-admin-orders-control', 'id');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_ord'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('dateshipped', 'Y-m-d H:i');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_dateshipped'));
        $this->addField($field);

        /*if (Shop_ModuleLoader::Get()->isImported('storage')) {
        $field = new Forms_ContentFieldSelectList('isshipped');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_shipped'));
        $field->setDataSource(new Datasource_OrderShipped());
        $this->addField($field);
        }*/

        /*$field = new Forms_ContentFieldDatetime('dateto', 'Y-m-d H:i');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_execute_to'));
        $field->setQuickedit(true);
        $this->addField($field);*/

        $field = new Forms_ContentFieldNumeric('sum');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_sum'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('currencyid');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_the_currency'));
        $field->setDataSource(new Datasource_Currency());
        $this->addField($field);

        /*if (Shop_ModuleLoader::Get()->isImported('finance')) {
            $field = new Shop_ContentField_Order_SumPayed('sum_payed');
            $field->setSortable(false);
            $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_sum_payed'));
            $this->addField($field);
        }*/

        $field = new Forms_ContentFieldSelectList('managerid');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_manager'));
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        /*if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Forms_ContentFieldSelectList('categoryid');
            $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_single_category'));
            $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_OrderCategory'));
            $field->setEmptyOptionValue(0);
            $this->addField($field);
        }*/

        /*$field = new Forms_ContentFieldSelectList('categoryid');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_single_category'));
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_OrderCategory'));
        $this->addField($field);*/

        $field = new Forms_ContentFieldSelectList('statusid');
        $field->setDataSource(new Datasource_OrderStatus());
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_status'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Shop_ContentFieldUserInfo('userid');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_the_client_user'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentField('clientname');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_fio'));
        $this->addField($field);

        /*$field = new Forms_ContentField('clientemail');
        $field->setName('Email');
        $this->addField($field);*/

        $field = new Forms_ContentField('clientphone');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_telephone'));
        $this->addField($field);

        $field = new Forms_ContentField('peoplecount');
        $field->setName('Количесто человек');
        $field->setQuickedit(1);
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('clientdatefrom', 'Y-m-d');
        $field->setName('Дата<br>заезда');
        $field->setQuickedit(1);
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('clientdateto', 'Y-m-d');
        $field->setName('Дата<br>выезда');
        $field->setQuickedit(1);
        $this->addField($field);

        /*$field = new Forms_ContentField('clientaddress');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_address'));
        $this->addField($field);*/

        /*$field = new Forms_ContentField('clientcontacts');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_contacts'));
        $this->addField($field);*/

        $field = new Forms_ContentFieldTextarea('comments');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_comment'));
        $field->setQuickedit(true);
        $this->addField($field);

      /*  $field = new Forms_ContentFieldSelectList('contractorid');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Contractors'));
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_legal_entity'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);*/

        /*if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Forms_ContentFieldSelectList('sourceid');
            $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Source'));
            $field->setName('Источник');
            $field->setQuickedit(true);
            $field->setEmptyOptionValue(0);
            $this->addField($field);
        }*/

        /*$field = new Shop_ContentFieldUserInfo('authorid');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setName('Оформил');
        $this->addField($field);*/

        $field = new Forms_ContentFieldDatetime('udate', 'Y-m-d H:i');
        $field->setName('Обновление');
        $this->addField($field);
    }

    private $_sqlobject;

}