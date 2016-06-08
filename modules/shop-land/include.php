<?php
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/ShopLand_ContentLoadObserver.class.php');

// регистрируем контенты в движке
Events::Get()->observe(
    'afterContentLoad',
    'ShopLand_ContentLoadObserver'
);