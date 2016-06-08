<?php
include_once(dirname(__FILE__).'/api/include.php');
include_once(dirname(__FILE__).'/api/errors.php');

PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Document_ContentLoadObserver.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Document_AdminMenu.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Document_ACL.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Document_DB.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Document_Sync.class.php');


Events::Get()->observe(
    'SQLObject.build.before',
    'Document_DB'
);

Events::Get()->observe(
    'SQLObject.build.after',
    'Document_Sync'
);

// регистрируем контенты в движке
Events::Get()->observe(
    'afterContentLoad',
    'Document_ContentLoadObserver'
);

// menu
Events::Get()->observe(
    'beforeBoxAdminMenuLoad',
    'Document_AdminMenu'
);

// подгрузка ACL по требованию
Events::Get()->observe(
    'buildACL',
    'Document_ACL'
);

// добавляем таб к заказу
Shop_ModuleLoader::Get()->registerOrderTabItem(
    Shop::Get()->getTranslateService()->getTranslateSecure('translate_documents'),
    'shop-admin-document-tab-order',
    'document',
    'documents'
);

// добавляем таб к юзеру
Shop_ModuleLoader::Get()->registerUserTabItem(
    Shop::Get()->getTranslateService()->getTranslateSecure('translate_documents'),
    'shop-admin-document-tab-user',
    'document',
    'documents'
);

Events::Get()->observe(
    'buildActionBlock',
    'Document_Action_Block_Build'
);

// в случае изменения определенных сущностей - запускать отложенную перестройку ACL
Events::Get()->addEvent('ShopDocumentTemplate.delete.after', 'SQLObject_Event');
Events::Get()->observe('ShopDocumentTemplate.delete.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');
Events::Get()->addEvent('ShopDocumentTemplate.update.after', 'SQLObject_Event');
Events::Get()->observe('ShopDocumentTemplate.update.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');
Events::Get()->addEvent('ShopDocumentTemplate.insert.after', 'SQLObject_Event');
Events::Get()->observe('ShopDocumentTemplate.insert.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');

// docs
include_once(dirname(__FILE__).'/docs/config.php');