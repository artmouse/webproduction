<?php

require_once(dirname(__FILE__) . '/../packages/Engine/include.2.6.php');

if (!Shop_ModuleLoader::Get()->isModuleInModulesArray('contact')) {
    return;
}

Engine::Get()->enableErrorReporting();
$fieldsAll = new XShopContactField();
$fieldsAll->addWhereQuery(
    'idkey = "phone" OR 
    idkey = "email" OR 
    idkey = "skype" OR 
    idkey = "jabber" OR 
    idkey = "whatsapp" OR 
    idkey = "address" OR 
    idkey = "source" OR 
    idkey = "contractor" OR 
    idkey = "bdate" OR 
    idkey = "url" OR 
    idkey = "parent" OR 
    idkey = "referral" OR 
    idkey = "links" OR 
    idkey = "tags" OR 
    idkey = "pricelevel" OR 
    idkey = "subscribe"'
);

while ($x = $fieldsAll->getNext()) {
    $fields = $x->getFields();

    $fieldNew = new XShopContactField();
    foreach ($fields as $field) {
        if ($field == 'id' || $field == 'idkey') {
            continue;
        }
        $fieldNew->setField($field, $x->getField($field));
    }
    $fieldNew->setIdkey('custom' . $x->getIdkey());
    $x->delete();
    $fieldNew->insert();
}

$fieldsAll = new XShopCustomField();
$fieldsAll->addWhereQuery(
    '`key` = "phone" OR 
    `key` = "email" OR 
    `key` = "skype" OR 
    `key` = "jabber" OR 
    `key` = "whatsapp" OR 
    `key` = "address" OR 
    `key` = "source" OR 
    `key` = "contractor" OR 
    `key` = "bdate" OR 
    `key` = "url" OR 
    `key` = "parent" OR 
    `key` = "referral" OR 
    `key` = "links" OR 
    `key` = "tags" OR 
    `key` = "pricelevel" OR 
    `key` = "subscribe"'
);

while ($x = $fieldsAll->getNext()) {
    $fields = $x->getFields();

    $fieldNew = new XShopCustomField();
    foreach ($fields as $field) {
        if ($field == 'id' || $field == 'key') {
            continue;
        }
        $fieldNew->setField($field, $x->getField($field));
    }
    $fieldNew->setKey('custom' . $x->getKey());
    $x->delete();
    $fieldNew->insert();
}

print "\n\ndone\n\n";