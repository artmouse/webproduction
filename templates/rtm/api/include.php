<?php

PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__) . '/db/');
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__) . '/system/');
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__) . '/service/');
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__) . '/forms/');

Shop::Get()->setShopService('RtmShopService');

if (PackageLoader::Get()->getMode('development')) {

    //добавить поле в настройки
    $sync = new SQLObjectSync_Data(new XShopSettings());

    $sync->addData(
        array(
            'key' => 'code-zhivosite',
        ), array(
            'value' => '',
        ), array(
            'name' => 'Код скрипта Живосайт',
            'type' => 'html',
            'tabname' => 'Интеграции',
            'description' => ''
        )
    );

    $sync->addData(
        array(
            'key' => 'code-istat',
        ), array(
            'value' => '',
        ), array(
            'name' => 'Код скрипта I-Stat',
            'type' => 'html',
            'tabname' => 'Интеграции',
            'description' => ''
        )
    );
    $sync->addData(
        array(
            'key' => 'code-istat-span-0',
        ), array(
            'value' => '',
        ), array(
            'name' => 'span 0 I-Stat',
            'type' => 'html',
            'tabname' => 'Интеграции',
            'description' => ''
        )
    );
    $sync->addData(
        array(
            'key' => 'code-istat-span-1',
        ), array(
            'value' => '',
        ), array(
            'name' => 'span 1 I-Stat',
            'type' => 'html',
            'tabname' => 'Интеграции',
            'description' => ''
        )
    );

    $sync->addData(
        array(
            'key' => 'code-istat-span-2',
        ), array(
            'value' => '',
        ), array(
            'name' => 'span 2 I-Stat',
            'type' => 'html',
            'tabname' => 'Интеграции',
            'description' => ''
        )
    );


    $sync->addData(
        array(
            'key' => 'code-google-tag-manager',
        ), array(
            'value' => '',
        ), array(
            'name' => 'Google tag manager code',
            'type' => 'html',
            'tabname' => 'Интеграции',
            'description' => 'Код Google tag manager'
        )
    );

    $sync->addData(
        array(
            'key' => 'site-robots-hide',
        ),
        array(
            'value' => 0,
        ),
        array(
            'name' => 'Скрыть сайт от индексации',
            'type' => 'boolean',
            'tabname' => 'Встроенные функции',
            'description' => 'На страници добавиться мета тег  " robots " content =" noindex, nofollow " '
        )
    );


    $sync->addData(
        array(
            'key' => 'show-nophoto-products',
        ),
        array(
            'value' => 1,
        ),
        array(
            'name' => 'Показывать товары без фото',
            'type' => 'boolean',
            'tabname' => 'Настройки магазина',
            'description' => ''
        )
    );


    $sync->addData(
        array(
            'key' => 'portmone-payee-id',
        ),
        array(
            'value' => '',
        ),
        array(
            'name' => 'PORTMONE.COM: Идентификатор магазина',
            'type' => 'string',
            'tabname' => 'Интеграции',
            'description' => 'Идентификатор торговой точки в системе PORTMONE.COM'
        )
    );


    $sync->addData(
        array(
            'key' => 'portmone-login',
        ),
        array(
            'value' => '',
        ),
        array(
            'name' => 'PORTMONE.COM: логин магазина',
            'type' => 'string',
            'tabname' => 'Интеграции',
            'description' => 'Логин торговой точки в системе PORTMONE.COM'
        )
    );


    $sync->addData(
        array(
            'key' => 'portmone-password',
        ),
        array(
            'value' => '',
        ),
        array(
            'name' => 'PORTMONE.COM: Пароль магазина',
            'type' => 'string',
            'tabname' => 'Интеграции',
            'description' => 'Пароль торговой точки в системе PORTMONE.COM'
        )
    );

    $sync->addData(
        array(
            'key' => 'trade-hall-photo',
        ),
        array(
            'value' => '', // /_images/bg.jpg
        ),
        array(
            'name' => 'Фото торгового зала',
            'type' => 'image',
            'tabname' => 'Настройки магазина',
            'description' => ''
        )
    );

    $sync->addData(
        array(
            'key' => 'trade-hall-photo-description',
        ),
        array(
            'value' => '',
        ),
        array(
            'name' => 'Фото торгового зала (описание)',
            'type' => 'string',
            'tabname' => 'Настройки магазина',
            'description' => ''
        )
    );

    $sync->addData(
        array(
            'key' => 'trade-hall-photo-text',
        ),
        array(
            'value' => '',
        ),
        array(
            'name' => 'Фото торгового зала (текст на фото)',
            'type' => 'string',
            'tabname' => 'Настройки магазина',
            'description' => ''
        )
    );

    $sync->sync();

    $settings = new XShopSettings();
    $settings->setKey('page-contact-company-name');
    $x = $settings->getNext();
    if (!$x) {

        $sync = new SQLObjectSync_Data(new XShopSettings());

        $sync->addData(
            array(
                'key' => 'page-contact-company-name',
            ), array(
                'value' => 'Контакты',
            ), array(
                'name' => 'Title страницы контакты',
                'type' => 'html',
                'tabname' => 'Текста',
                'description' => 'Название страницы контакты'
            )
        );
        $sync->sync();
    }

    $table = SQLObject_Config::Get()->addClass('XShopProduct', 'shopproduct');
    $table->addField('descriptionshort', 'text'); // краткое описание
    $table->addField('price_product', 'decimal(10,2)'); // Цена за изделие
    $table->addField('videoUrl', 'varchar(255)'); // Ссылка на видео (YouTube)
    $table->addField('jewelerid', 'int(11)');
    $table->addField('baseweight', 'varchar(255)'); // базовый вес
    $table->addField('exchangeweight', 'varchar(255)'); // вес для обмена
    $table->addField('inventarnumber', 'varchar(255)'); // инвентарный номер
    $table->addField('vstavka', 'text'); // Описания камня вставки
    $table->addField('size', 'float'); // Размер товара
    $table->addField('subarticul', 'varchar(255)'); // субартикул
    $table->addField('showincategory', 'tinyint(1)'); // показывать товар в категорие
    $table->addField('price_product_old', 'decimal(10,2)'); // Зачеркнутая цена продукта
    $table->addField('tech_image', 'varchar(255)'); // к фотке подгружается техническая фотография
    $table->addField('user_view', 'tinyint(1)'); // товары не отмеченные этим полем простой полбзователь не видит
    $table->addField('abouturl', 'varchar(255)'); // Ссылка на статью о товаре

    // shop order items
    $table = SQLObject_Config::Get()->addClass('XShopOrderProduct', 'shoporderproduct');
    $table->addField('buyOrExchange', 'enum("buy", "exchange")');

    // basket - корзина
    $table = SQLObject_Config::Get()->addClass('XShopBasket', 'shopbasket');
    $table->addField('buyOrExchange', 'enum("buy", "exchange")');

    $table = SQLObject_Config::Get()->addClass('XRtmImport', 'rtmimport');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('cdate', 'datetime');
    $table->addField('pdate', 'datetime');
    $table->addField('userid', 'int(11)');
    $table->addField('file', 'varchar(255)');
    $table->addField('storagenameid', 'int(11)');
    $table->addField('importimages', 'int(3)');

    // Ювелиры
    $table = SQLObject_Config::Get()->addClass('XJeweler', 'rtm_jeweler');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)');
    $table->addField('image', 'varchar(255)');
    $table->addField('description', 'text');

    $table = SQLObject_Config::Get()->addClass('XFilterValue2Url', 'filter_value2url');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('url', 'varchar(255)');
    $table->addField('value', 'varchar(255)');
    $table->addField('filterid', 'int(11)');

    $table = SQLObject_Config::Get()->addClass('XCategorySizes', 'categorysizes');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('categoryid', 'int(11)');
    $table->addField('sizes', 'text');

    // shop payment - способы оплаты
    $table = SQLObject_Config::Get()->addClass('XShopPayment', 'shoppayment');
    $table->addField('additionalinfo', 'text'); // Дополнительная информация
    $table->addField('showinfo', 'tinyint(1)'); // Показывать дополнительную информацию
    $table->addField('default', 'tinyint(1)'); // Показывать дополнительную информацию

    // shop delivery
    $table = SQLObject_Config::Get()->addClass('XShopDelivery', 'shopdelivery');
    $table->addField('paydelivery', 'tinyint(1)'); // учет доставки в сумму заказа

    $table = SQLObject_Config::Get()->addClass('XShopOrder', 'shoporder');
    $table->addField('utm_source', 'varchar(255)');
    $table->addField('utm_medium', 'varchar(255)');
    $table->addField('utm_campaign', 'varchar(255)');
    $table->addField('utm_content', 'varchar(255)');
    $table->addField('utm_term', 'varchar(255)');
    $table->addField('utm_date', 'datetime');
    $table->addField('utm_referrer', 'varchar(255)');

    $table = SQLObject_Config::Get()->addClass('XShopNews', 'shopnews');
    $table->addField('pageid', 'int(11)');

    SQLObject_Config::Get()->process();
}


// задаем собственный URLParser
Engine::Get()->setURLParser(Rtm_URLParser::Get());

Events::Get()->observe(
    'afterCronHour', new Shop_CronImportProductsXML()
);

Events::Get()->observe(
    'afterCronHour', new Shop_CronImportImages()
);

// подключение сихронизатора базы данных
// запись дефолтных данных
$connection = ConnectionManager::Get()->getConnectionMySQL();
if (PackageLoader::Get()->getMode('development') && isset($connection)) {
    try {
        SQLObject::TransactionStart();

        include(dirname(__FILE__) . '/sync/include.php');

        SQLObject::TransactionCommit();
    } catch (Exception $ge) {
        SQLObject::TransactionRollback();
        throw $ge;
    }
}