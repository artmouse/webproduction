<?php
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SupplierPrice_ContentLoadObserver.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SupplierPrice_AdminMenu.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SupplierPrice_ACL.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SupplierPrice_DB.class.php');

include_once(dirname(__FILE__).'/errors.php');

Events::Get()->observe(
    'SQLObject.build.before',
    'SupplierPrice_DB'
);
// регистрируем контенты в движке
Events::Get()->observe(
    'afterContentLoad',
    'SupplierPrice_ContentLoadObserver'
);

// menu
Events::Get()->observe(
    'beforeBoxAdminMenuLoad',
    'SupplierPrice_AdminMenu'
);

// подгрузка ACL по требованию
Events::Get()->observe(
    'buildACL',
    'SupplierPrice_ACL'
);

// docs
include_once(dirname(__FILE__).'/docs/config.php');

PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/api/system/SupplierPrice_Action_Block_Build.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/api/system/ShopSupplier_Processor_Avail.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/api/system/ShopSupplier_Processor_UploadProducts.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/api/system/ShopSupplier_Processor_ReadPrice.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/api/forms/Datasource_TmpPrice.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/api/forms/Shop_contentFieldSearchProduct.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/api/forms/Shop_ContentTableRowProductsSupplier.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/api/forms/Datasource_IgnoreProductsPrice.class.php');


Events::Get()->observe(
    'buildActionBlock',
    'SupplierPrice_Action_Block_Build'
);