<?php

class Datasource_FinanceInvoice extends Forms_ADataSourceSQLObject {

    public function __construct($linkkey = false, $datefrom = false, $dateto = false,
    $clientIDArray = false, $contractorIDArray = false, $userIDArray = false) {
        parent::__construct();

        $this->_linkkey = $linkkey;

        $this->_datefrom = $datefrom;
        $this->_dateto = $dateto;

        $this->_clientIDArray = $clientIDArray;
        $this->_userIDArray = $userIDArray;
        $this->_contractorIDArray = $contractorIDArray;
    }

    /**
     * SQLObject
     *
     * @return FinanceInvoice
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $x = InvoiceService::Get()->getInvoicesAll();

            if ($this->_linkkey) {
                $x->setLinkkey($this->_linkkey);
            }

            // фильтр по датам

            if ($this->_datefrom) {
                $this->_datefrom = DateTime_Corrector::CorrectDateTime($this->_datefrom);
                $x->addWhereQuery('( DATE(`cdate`) >= \''.$this->_datefrom.'\' )');
            }
            if ($this->_dateto) {
                $this->_dateto = DateTime_Corrector::CorrectDateTime($this->_dateto);
                $x->addWhereQuery('( DATE(`cdate`) <= \''.$this->_dateto.'\' )');
            }

            // фильтр по клиенту
            if ($this->_clientIDArray) {
                $x->addWhereArray($this->_clientIDArray, 'clientid');
            }

            // фильтр по менеджеру
            if ($this->_userIDArray) {
                $x->addWhereArray($this->_userIDArray, 'userid');
            }

            // фильтр по юр лицу
            if ($this->_contractorIDArray) {
                $x->addWhereArray($this->_contractorIDArray, 'contractorid');
            }


            $this->_sqlobject = $x;
        }
        return $this->_sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('cdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sozdan'));
        $this->addField($field);
        
        $field = new Forms_ContentFieldDatetime('date', 'Y-m-d');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_vistavlen'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('type');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_FinanceInvoice_Type'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_type_shot'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('clientid', true);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_client_small'));
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('sum');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sum'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('currencyid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_currency'));
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Currency'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('contractorid');
        $field->setName('Юр. лицо');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Contractors'));
        $this->addField($field);

        $field = new Finance_ContentField_Invoice_Link('linkkey');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_privyazka'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('userid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_manager'));
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $this->addField($field);
    }

    private $_sqlobject;
    private $_linkkey;
    private $_datefrom;
    private $_dateto;
    private $_clientIDArray;
    private $_userIDArray;
    private $_contractorIDArray;

}