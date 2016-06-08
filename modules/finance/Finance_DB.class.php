<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * событие для перестройки базы данных (SQLObject Sync)
 *
 * @author    i.ustimenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Finance_DB implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        // аккаунты (счета) компании
        $table = SQLObject_Config::Get()->addClass('XFinanceAccount', 'financeaccount');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('description', 'text');
        $table->addField('currencyid', 'int(11)');
        $table->addField('contractorid', 'int(11)');
        $table->addField('balancestart', 'decimal(15,2)');
        $table->addField('active', 'tinyint(1)');
        // indexes
        $table->addIndex(array('active', 'name'), 'index_activename');

        // ожидаемый платеж
        $table = SQLObject_Config::Get()->addClass('XFinanceProbation', ' financeprobation');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('orderid', 'int(11)');
        $table->addField('cdate', 'datetime');
        $table->addField('pdate', 'date');
        $table->addField('amount', 'decimal(15,2)');
        $table->addField('amountbase', 'decimal(15,2)'); // сумма в системной валюте
        $table->addField('currencyid', 'int(11)');
        $table->addField('managerid', 'int(11)');
        $table->addField('received', 'tinyint(1)');
        $table->addField('accountid', 'int(11)');
        $table->addField('contractorid', 'int(11)'); 
        // indexes
        $table->addIndex('orderid', 'index_orderid');
        $table->addIndex('pdate', 'index_pdate');

        // категории платежей
        $table = SQLObject_Config::Get()->addClass('XFinanceCategory', 'financecategory');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('active', 'tinyint(1)');
        $table->addField('fundpercent', 'int(11)');
        $table->addField('fundsum', 'decimal(15,2)');
        $table->addField('fundtotal', 'decimal(15,2)');
        $table->addField('lastpaymentid', 'int(11)');
        $table->addField('isfund', 'tinyint(1)');
        // indexes
        $table->addIndex(array('active', 'name'), 'index_activename');
        $table->addIndex('isfund', 'index_isfund');

        // платежи между аккаунтами и клиентами
        $table = SQLObject_Config::Get()->addClass('XFinancePayment', 'financepayment');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime'); // дата создания
        $table->addField('pdate', 'datetime'); // дата проводки (когда платеж стал активен)
        $table->addField('rdate', 'datetime'); // дата отказа
        $table->addField('amount', 'decimal(15,2)');
        $table->addField('amountbase', 'decimal(15,2)'); // сумма в системной валюте
        $table->addField('currencyid', 'int(11)');
        $table->addField('currencyrate', 'decimal(15,2)'); // курс к базовой валюте на момент оплаты
        $table->addField('accountid', 'int(11)');
        $table->addField('clientid', 'int(11)');
        $table->addField('userid', 'int(11)');
        $table->addField('categoryid', 'int(11)');
        $table->addField('code', 'varchar(255)');
        $table->addField('orderid', 'int(11)'); // привязка к заказу
        $table->addField('orderamountbase', 'decimal(15,2)'); // сумма в валюте заказа
        $table->addField('linkkey', 'varchar(255)');
        $table->addField('bankdetail', 'text');
        $table->addField('comment', 'text');
        $table->addField('invoiceid', 'int(11)');
        $table->addField('file', 'varchar(255)');
        $table->addField('filename', 'varchar(255)');
        $table->addField('referalprocessed', 'tinyint(1)'); // обработан на выплату реферальных
        $table->addField('noBalance', 'tinyint(1)'); // не учитывать в баланс
        $table->addField('deleted', 'tinyint(1)'); // удаленный платеж
        // индексы
        $table->addIndex('accountid', 'index_accountid');
        $table->addIndex('orderid', 'index_orderid');
        $table->addIndex('clientid', 'index_clientid');
        $table->addIndex('linkkey', 'index_linkkey');
    }

}