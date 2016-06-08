<?php
// подключаем help конфиг
include_once(dirname(__FILE__).'/docs/config.php');

PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/ApiDocs_ContentLoadObserver.class.php');

// регистрируем контенты в движке
Events::Get()->observe(
    'afterContentLoad',
    'ApiDocs_ContentLoadObserver'
);