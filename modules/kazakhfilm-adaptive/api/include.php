<?php

if (PackageLoader::Get()->getMode('development')) {
    $table = SQLObject_Config::Get()->addClass('XShopProduct', 'shopproduct');
    $table->addField('sort', 'int(11)');
    $table->addField('price_half', 'decimal(10,2)');

    $table = SQLObject_Config::Get()->addClass('XShopOrder', 'shoporder');
    $table->addField('clientdatefrom', 'datetime');
    $table->addField('clientdateto', 'datetime');
    $table->addField('peoplecount', 'varchar(255)');

    $table = SQLObject_Config::Get()->addClass('XShopGuestBook', 'shopguestbook');
    $table->addField('email', 'varchar(255)');
    $table->addField('main', 'tinyint(1)');

    $table = SQLObject_Config::Get()->addClass('XShopTransfer', 'shoptransfer');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addField('name', 'varchar(255)');
    $table->addField('telephone', 'varchar(255)');
    $table->addIndexPrimary('id');

    $table = SQLObject_Config::Get()->addClass('XShopOrder', 'shoporder');
    $table->addField('clientdatefrom', 'datetime');
    $table->addField('clientdateto', 'datetime');
    $table->addField('peoplecount', 'varchar(255)');

    $table = SQLObject_Config::Get()->addClass('XMainText', 'shopmaintext');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addField('text', 'text');
    $table->addField('num', 'int(11)');
    $table->addIndexPrimary('id');






    SQLObject_Config::Get()->process();
}
