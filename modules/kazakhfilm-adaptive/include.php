<?php
include_once(dirname(__FILE__).'/api/include.php');

PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/api/');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/api/Kazakh_DB.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Kazakhfilm_Content.class.php');
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/_images/');
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/_js/');


// регистрируем контенты в движке
Events::Get()->observe(
    'afterContentLoad',
    'Kazakhfilm_Content'
);


Events::Get()->observe(
    'SQLObject.build.before',
    'Kazakh_DB'
);



/*
if (PackageLoader::Get()->getMode('development')) {
    Shop::Get()->getBlockService()->addBlock('kazakh-order', 'block-kazakh-order', 'template_order');
}
*/