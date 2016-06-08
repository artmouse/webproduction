<?php
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Collars_Contents.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/api/forms/Datasource_TextPage.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/api/Collars_DB.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/api/forms/Datasource_Brand.class.php');
// регистрируем контенты в движке
Events::Get()->observe(
    'afterContentLoad',
    'Collars_Contents'
);

// объявляем событие
Events::Get()->addEvent(
    'Datasource_TextPages.initialize.after',
    new Forms_Event_DataSource()
);



Events::Get()->observe(
    'SQLObject.build.before',
    'Collars_DB'
);

// дописываем поле в Datasource_IssueCustom цель проекта
Events::Get()->observe(
    'Datasource_TextPages.initialize.after',
    'Datasource_TextPage'
);

Events::Get()->addEvent(
    'Datasource_Brands.initialize.after',
    new Forms_Event_DataSource()
);

Events::Get()->observe(
    'Datasource_Brands.initialize.after',
    'Datasource_Brand'
);