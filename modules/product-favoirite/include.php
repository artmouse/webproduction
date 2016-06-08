<?php
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Favorite_Contents.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/api/services/FavoriteService.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/ProductFavorite_DB.class.php');

Events::Get()->observe(
    'SQLObject.build.before',
    'ProductFavorite_DB'
);

// регистрируем контенты в движке
Events::Get()->observe(
    'afterContentLoad',
    'Favorite_Contents'
);

Shop_ModuleLoader::Get()->registerProfileTabItem(
    'Избранное',
    'shop-client-favorite',
    'product-favorite'
);