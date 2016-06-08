<?php
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/services/');
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/system/');
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/forms/');

// обработчик удаления заказа
Events::Get()->observe(
    'shopOrderDeleteBefore',
    'Document_OrderDeleteHandler'
);