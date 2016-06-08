<?php

class Datasource_FinancePayment extends Forms_ADataSourceSQLObject {

    public function __construct($accountID = false, $contractorID = false,
    $datetype = false, $datefrom = false, $dateto = false, $clientIDArray = false,
    $userIDArray = false, $categoryIDArray = false, $invoiceID = false,
    $linkkey = false, $comment = false) {
        parent::__construct();

        $this->_accountID = $accountID;
        $this->_contractorID = $contractorID;
        $this->_datetype = $datetype;
        $this->_datefrom = $datefrom;
        $this->_dateto = $dateto;
        $this->_clientIDArray = $clientIDArray;
        $this->_userIDArray = $userIDArray;
        $this->_categoryIDArray = $categoryIDArray;
        $this->_invoiceID = $invoiceID;
        $this->_linkkey = $linkkey;
        $this->_comment = $comment;
    }

    /**
     * SQLObject
     *
     * @return FinancePayment
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $user = Shop::Get()->getUserService()->getUser();

            $payments = PaymentService::Get()->getPaymentsByUser($user);

            // фильтр по аккаунту
            if ($this->_accountID) {
                $payments->setAccountid($this->_accountID);

                // фильтр по юр лицу
            } elseif ($this->_contractorID) {
                $accounts = FinanceService::Get()->getAccountsAll();
                $accounts->setContractorid($this->_contractorID);

                $accountIDArray = array(-1);
                while ($x = $accounts->getNext()) {
                    $accountIDArray[] = $x->getId();
                }
                $payments->addWhereArray($accountIDArray, 'accountid');
            }

            // фильтр по датам
            if ($this->_datetype && ($this->_datefrom || $this->_dateto) &&
            in_array($this->_datetype, array('cdate', 'pdate', 'rdate'))) {
                if ($this->_datefrom) {
                    $this->_datefrom = DateTime_Corrector::CorrectDateTime($this->_datefrom);
                    $payments->addWhereQuery('( DATE(`'.$this->_datetype.'`) >= \''.$this->_datefrom.'\' )');
                }
                if ($this->_dateto) {
                    $this->_dateto = DateTime_Corrector::CorrectDateTime($this->_dateto);
                    $payments->addWhereQuery('( DATE(`'.$this->_datetype.'`) <= \''.$this->_dateto.'\' )');
                }
            }

            if ($this->_comment) {
                $payments->addWhere('comment', "%".$this->_comment."%", 'like');
            }

            // фильтр по клиенту
            if ($this->_clientIDArray) {
                $payments->addWhereArray($this->_clientIDArray, 'clientid');
            }

            // фильтр по менеджеру
            if ($this->_userIDArray) {
                $payments->addWhereArray($this->_userIDArray, 'userid');
            }

            // фильтр по категории
            if ($this->_categoryIDArray) {
                $payments->addWhereArray($this->_categoryIDArray, 'categoryid');
            }

            if ($this->_invoiceID) {
                $payments->setInvoiceid($this->_invoiceID);
            }

            if ($this->_linkkey) {
                $payments->setLinkkey($this->_linkkey);
            }

            $this->_sqlobject = $payments;
        }
        return $this->_sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('cdate', 'Y-m-d H:i');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sozdan'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('pdate', 'Y-m-d H:i');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_proveden'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('rdate', 'Y-m-d H:i');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_otklonen'));
        $field->setValueDefault('');
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('accountid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_akkaunt'));
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_FinanceAccount'));
        $this->addField($field);

        $field = new Finance_ContentField_Payment_Sum('amount');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sum'));
        $this->addField($field);

        $field = new Finance_ContentField_Sum_with_Currency('amountbase');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_summa_v_bazovoy_valyute'));
        $this->addField($field);

        $field = new Finance_ContentField_Payment_Link('linkkey');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_klient_privyazka'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('comment');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_comment'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('categoryid', true);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_single_category'));
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_FinanceCategory'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        /*$field = new Forms_ContentField('code');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_code'));
        $this->addField($field);*/

        /*$field = new Forms_ContentFieldTextarea('bankdetail');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_banking_details'));
        $this->addField($field);*/

        $field = new Shop_ContentFieldUserInfo('userid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_manager'));
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Shop_ContentFieldNoBalance('noBalance');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_proveden'));
        $this->addField($field);
    }

    private $_sqlobject;

    private $_accountID;
    private $_contractorID;
    private $_datetype;
    private $_datefrom;
    private $_dateto;
    private $_clientIDArray;
    private $_userIDArray;
    private $_categoryIDArray;
    private $_invoiceID;
    private $_linkkey;
    private $_comment;

}