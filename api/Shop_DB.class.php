<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * событие для перестройки базы данных (SQLObject Sync)
 *
 * @author    i.ustimenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Shop_DB implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        // очищаем api/db/index.php
        file_put_contents(PackageLoader::Get()->getProjectPath().'/api/db/index.php', "<?php\n", LOCK_EX);

        // users (клиенты и юзеры)
        $table = SQLObject_Config::Get()->addTable('users', 'XUser');
        $table->addField('id', 'bigint(20) UNSIGNED', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('login', 'varchar(255)');
        $table->addField('password', 'varchar(255)');
        $table->addField('level', 'int(11)');
        $table->addField('cdate', 'datetime');
        $table->addField('email', 'varchar(255)');
        $table->addField('name', 'varchar(255)');
        $table->addField('namelast', 'varchar(255)');
        $table->addField('namemiddle', 'varchar(255)');
        $table->addField('image', 'varchar(255)');
        $table->addField('phone', 'varchar(20)');
        $table->addField('phones', 'text');
        $table->addField('address', 'text');
        $table->addField('bdate', 'date');
        $table->addField('urls', 'text');
        $table->addField('emails', 'text');
        $table->addField('skype', 'text');
        $table->addField('jabber', 'varchar(255)');
        $table->addField('whatsapp', 'varchar(255)');
        $table->addField('parentid', 'int(11)');
        $table->addField('time', 'varchar(255)'); // удобное время для связи
        $table->addField('commentadmin', 'text'); // коментарии админа
        $table->addField('managerid', 'int(11)'); // менеджер
        $table->addField('company', 'varchar(255)'); // компания
        $table->addField('post', 'varchar(255)'); // должность
        $table->addField('groupid', 'int(11)'); // группа // @deprecated
        $table->addField('pricelevel', 'int(11)'); // уровень цен
        $table->addField('discountid', 'int(11)'); // скидка
        $table->addField('activatecode', 'varchar(16)'); // код активации акаунта
        $table->addField('distribution', 'tinyint(1)'); // Подписан ли на рассылку
        $table->addField('tags', 'varchar(255)');
        $table->addField('edate', 'datetime'); // дата/время актуальности пользователя
        $table->addField('udate', 'datetime'); // дата/время обновления юзера
        $table->addField('contractorid', 'int(11)'); // юридическое лицо
        $table->addField('sourceid', 'int(11)'); // источник
        $table->addField('authorid', 'int(11)'); // кто автор (не редактируется)
        $table->addField('typesex', 'varchar(16)'); // тип/пол клиента
        $table->addField('activitydate', 'datetime'); // дата последней активности
        $table->addField('activitydatein', 'datetime'); // дата последней активности in
        $table->addField('activitydateout', 'datetime'); // дата последней активности out
        $table->addField('employer', 'tinyint(1)'); // сотрудник
        $table->addField('allowreferal', 'int(11)'); // Выплачиваются реферальные / партнерские
        $table->addField('utm_source', 'varchar(255)');
        $table->addField('utm_medium', 'varchar(255)');
        $table->addField('utm_campaign', 'varchar(255)');
        $table->addField('utm_content', 'varchar(255)');
        $table->addField('utm_term', 'varchar(255)');
        $table->addField('utm_date', 'datetime');
        $table->addField('utm_referrer', 'varchar(255)');
        $table->addField('identifier', 'varchar(35)'); // md5 идентификатор пользователя для автоматической авторизации
        $table->addField('lost_basket', 'datetime'); // нужно отослать письмо про забытую корзину
        $table->addField('code1c', 'varchar(32)'); // код 1c
        $table->addField('worktimesystem', 'tinyint(1)'); // разрешать работать только в заданное рабочее время
        $table->addField('voipblock', 'tinyint(1)'); // Показывать всплывающее окно при входящем звонке
        $table->addField('ip', 'varchar(15)'); // ip users
        $table->addField('notificationblock', 'tinyint(1)'); // Показывать уведомления
        
        $letterCount = 5;
        for ($j=1;$j<=$letterCount;$j++) {
            $table->addField('lost_basket_date'.$j, 'datetime'); // время когда отправлять письмо про забытую корзину
        }
        $table->addField('notify_email_one', 'tinyint(1)');
        $table->addField('notify_email_group', 'tinyint(1)');
        $table->addField('notify_sms', 'tinyint(1)');
        $table->addField('controlip', 'varchar(15)'); // разрешенный IP адрес
        $table->addField('deleted', 'tinyint(1)'); // удален или нет
        // индексы
        $table->addIndex('activatecode', 'index_activatecode');
        $table->addIndex(array('login', 'email'), 'index_loginemail');
        $table->addIndex('typesex', 'index_typesex');
        $table->addIndex('company', 'index_company');
        $table->addIndex(array('employer', 'deleted', 'namelast', 'name'), 'index_employername');
        $table->addIndex('lost_basket', 'index_lostbasket');
        $table->addIndex('name', 'index_name');
        $table->addIndex('namelast', 'index_namelast');
        $table->addIndex('namemiddle', 'index_namemiddle');
        $table->addIndex('post', 'index_post');
        $table->addIndex('email', 'index_email');
        $table->addIndex('phone', 'index_phone');
        $table->addIndex(array('deleted', 'namelast', 'name'), 'index_deleted');
        $table->addIndex('parentid', 'index_parentid');
        $table->addIndex('code1c', 'index_code1c');
        $table->addIndex('level', 'index_level');

        // данные авторизации. Вынесены в отдельную таблицу со связью 1:1,
        // специально чтобы не гробить MySQL Query Cache
        $table = SQLObject_Config::Get()->addTable('userauth', 'XUserAuth');
        $table->addField('id', 'bigint(20) UNSIGNED', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('userid', 'bigint(20) UNSIGNED');
        $table->addField('adate', 'datetime');
        $table->addField('sdate', 'datetime');
        $table->addField('sid', 'char(32)');
        $table->addField('ip', 'char(15)');
        // indexes
        $table->addIndexUnique('sid', 'index_sid');
        $table->addIndex('userid', 'index_userid');
        $table->addIndex('adate', 'index_adate');

        // телефоны юзеров
        $table = SQLObject_Config::Get()->addClass('XShopUserPhone', 'shopuserphone');
        $table->addField('id', 'bigint(20) UNSIGNED', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('userid', 'bigint(20) UNSIGNED');
        $table->addField('phone', 'varchar(20)');
        // indexes
        $table->addIndex('userid', 'index_userid');
        $table->addIndexUnique(array('phone', 'userid'), 'index_phoneuserid');

        // email юзеров
        $table = SQLObject_Config::Get()->addClass('XShopUserEmail', 'shopuseremail');
        $table->addField('id', 'bigint(20) UNSIGNED', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('userid', 'bigint(20) UNSIGNED');
        $table->addField('email', 'varchar(255)');
        // indexes
        $table->addIndex('userid', 'index_userid');
        $table->addIndexUnique(array('email', 'userid'), 'index_emailuserid');

        // список ключей доступа (ACL keys)
        $table = SQLObject_Config::Get()->addClass('XUserACLKey', 'useraclkey');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('key', 'varchar(255)');
        $table->addField('name', 'varchar(255)');
        $table->addField('deleted', 'tinyint(1)');
        // индексы
        $table->addIndex('key', 'index_key');
        $table->addIndex('name', 'index_name');
        $table->addIndex('deleted', 'index_deleted');

        // права доступа конкретного юзера
        $table = SQLObject_Config::Get()->addClass('XUserACL', 'useracl');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('userid', 'int(11)');
        $table->addField('acl', 'varchar(255)');
        // индексы
        $table->addIndex('userid', 'index_userid');

        // группы пользователей
        $table = SQLObject_Config::Get()->addClass('XShopUserGroup', 'shopusergroup');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('description', 'varchar(255)');
        $table->addField('group', 'varchar(50)');
        $table->addField('sort', 'int(11)');
        $table->addField('logicclass', 'varchar(255)');
        $table->addField('colour', 'varchar(255)');
        $table->addField('pricelevel', 'int(11)'); // уровень цен
        $table->addField('cnt', 'int(11)'); // количество контактов в группе
        $table->addField('cntlast', 'int(11)'); // сколько было на вчера
        $table->addField('parentid', 'int(11)');
        // индексы
        $table->addIndex('group', 'index_group');
        $table->addIndex('sort', 'index_sort');
        $table->addIndex('parentid', 'index_parentid');

        // contacts-to-groups
        $table = SQLObject_Config::Get()->addClass('XShopUser2Group', 'shopuser2group');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('userid', 'int(11)');
        $table->addField('groupid', 'int(11)');
        // индексы
        $table->addIndexUnique(array('groupid', 'userid'), 'index_groupiduserid');

        // расширение комментариев поляем type
        $table = SQLObject_Config::Get()->addClass('CommentsAPI_XComment', 'commentsapi_comment');
        $table->addField(
            'type',
            "enum('comment','notify','change','call','ecall','email','sms','commentresult','document')"
        );
        // indexes
        $table->addIndex('type', 'index_type');

        // дерево ролей
        $table = SQLObject_Config::Get()->addClass('XShopRole', 'shoprole');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('description', 'varchar(255)');
        $table->addField('blockcolor', 'varchar(7)');
        $table->addField('parentid', 'int(11)');
        for ($j = 1; $j <= 10; $j++) {
            $table->addField('kpi'.$j.'id', 'int(11)'); // ключевой показатель
            $table->addField('kpi'.$j.'param', 'varchar(32)'); // дополнительный параметр
            $table->addField('kpi'.$j.'value', 'decimal(10,2)'); // желаемый факт показателя
            $table->addField('salary'.$j.'workflowid', 'int(11)'); // БП для начисления ЗП
            $table->addField('salary'.$j.'koef', 'float'); // коеффициент, по которому KPI превращается в ЗП
        }
        // indexes
        $table->addIndex('name', 'index_name');
        $table->addIndex('parentid', 'index_parentid');

        // история звонков и пистем
        $table = SQLObject_Config::Get()->addClass('XShopEvent', 'shopevent');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('type', "enum('call','sms','email','meeting','skype','jabber','whatsapp')"); // тип события
        $table->addField('cdate', 'datetime');
        $table->addField('session', 'varchar(255)'); // идентификатор сессии
        $table->addField('from', 'varchar(255)');
        $table->addField('to', 'varchar(255)');
        $table->addField('channel', 'varchar(255)'); // канал (для звонков)
        $table->addField('sourceid', 'int(11)'); // канал (идентификатор источника)
        $table->addField('subject', 'varchar(255)');
        $table->addField('subjectgroup', 'varchar(255)'); // обработанный subject для группировки
        $table->addField('content', 'text');
        $table->addField('file', 'varchar(255)'); // путь к звонку
        $table->addField('location', 'varchar(255)'); // геопозиция
        $table->addField('duration', 'int(11)'); // длительность в секундах
        $table->addField('status', 'varchar(16)'); // статус (используется для звонков)
        $table->addField('hidden', 'tinyint(1)');
        $table->addField('hash', 'varchar(32)'); // md5-хеш для группировки от дублирования
        $table->addField('direction', 'int(2)'); // 0 - не известно, -1 - входящий в компанию, +1 - исходящий
        $table->addField('replyid', 'int(11)');
        $table->addField('replydate', 'datetime');
        $table->addField('rating', 'int(3)');
        $table->addField('fromuserid', 'int(11)'); // ссылки на конкретного юзера
        $table->addField('touserid', 'int(11)'); // ссылки на конкретного юзера
        $table->addField('mailbox', 'varchar(32)'); // папка в которой было письмо
        $table->addField('comment', 'text'); // комментарий
        // индексы
        $table->addIndex('cdate', 'index_cdate');
        $table->addIndex('type', 'index_type');
        $table->addIndex(array('from', 'to', 'cdate'), 'index_from');
        $table->addIndex(array('to', 'from', 'cdate'), 'index_to');
        $table->addIndex(array('subject', 'cdate'), 'index_subject');
        $table->addIndex(array('touserid', 'fromuserid', 'cdate'), 'index_touserid');
        $table->addIndex(array('fromuserid', 'touserid', 'cdate'), 'index_fromuserid');
        $table->addIndex(array('subjectgroup', 'type', 'cdate'), 'index_subjectgroup');

        // спам-лист
        $table = SQLObject_Config::Get()->addTable('shopeventignore', 'XShopEventIgnore');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('address', 'varchar(64)');
        $table->addField('spam', 'tinyint(1)'); // даже не парсить
        $table->addField('notify', 'tinyint(1)'); // не показывать уведомления
        $table->addField('unknown', 'tinyint(1)'); // неизвестный адрес
        // indexes
        $table->addIndex('address', 'index_address');

        // купоны
        $table = SQLObject_Config::Get()->addTable('shopcoupon', 'XShopCoupon');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('code', 'varchar(50)');
        $table->addField('dateused', 'datetime');
        $table->addField('amount', 'decimal(15,2)');
        $table->addField('currencyid', 'int(11)');
        $table->addField('orderid', 'int(11)');
        $table->addField('comment', 'text');
        $table->addField('sendcoupon', 'tinyint(1)');
        // indexes
        $table->addIndexUnique('code', 'index_code');

        // группировка товаров
        $table = SQLObject_Config::Get()->addTable('shopproductgrouped', 'XShopProductGrouped');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('categoryid', 'int(11)');
        $table->addField('productid', 'int(11)');
        $table->addField('first', 'tinyint(1)');
        $table->addField('image', 'varchar(255)');
        $table->addField('groupedfield', 'varchar(255)');
        // index
        $table->addIndex(array('productid', 'categoryid'), 'index_productcategory');
        $table->addIndex(array('first', 'groupedfield'), 'index_firstgroupedfield');

        // теги к товарам
        $table = SQLObject_Config::Get()->addTable('shopproducttag', 'XShopProductTag');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('url', 'varchar(255)');
        $table->addField('description', 'text');
        // index
        $table->addIndexUnique(array('name'), 'index_name');

        // связи тегов и товаров
        $table = SQLObject_Config::Get()->addTable('shopproduct2tag', 'XShopProduct2Tag');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('productid', 'int(11)');
        $table->addField('tagid', 'int(11)');
        // index
        $table->addIndexUnique(array('productid', 'tagid'), 'index_link');

        // вложения для событий
        // @deprecated: переходим на ShopFile
        $table = SQLObject_Config::Get()->addTable('shopeventattachment', 'XShopEventAttachment');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('eventid', 'int(11)');
        $table->addField('file', 'varchar(255)');
        $table->addField('name', 'varchar(255)');
        $table->addField('contenttype', 'varchar(255)');
        // index
        $table->addIndex('eventid', 'index_eventid');

        // events / email imap last UID
        $table = SQLObject_Config::Get()->addTable('shopeventemailuid', 'XShopEventEmailUID');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('imap', 'varchar(255)');
        $table->addField('uid', 'varchar(255)');
        // indexes
        $table->addIndex('imap', 'index_imap');

        // рекомендуемое время связи с контактом
        $table = SQLObject_Config::Get()->addTable('shopusereventrecommend', 'XShopUserEventRecommend');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('userid', 'int(11)');
        $table->addField('day', 'int(11)');
        $table->addField('time', 'varchar(255)');
        // index
        $table->addIndex(array('userid', 'day'), 'index_userid');
        $table->addIndex(array('day', 'userid'), 'index_day');

        // предсказание событий контакта
        $table = SQLObject_Config::Get()->addTable('shopusereventprediction', 'XShopUserEventPrediction');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('userid', 'int(11)');
        $table->addField('cdate', 'datetime');
        $table->addField('pdate', 'datetime');
        $table->addField('probablity', 'float');
        $table->addField('comment', 'text');
        // index
        $table->addIndex(array('userid', 'pdate'), 'index_userid');
        $table->addIndex(array('pdate', 'userid'), 'index_pdate');

        // юридические реквизиты клиентов
        $table = SQLObject_Config::Get()->addClass('XShopUserLegal', 'shopuserlegal');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('userid', 'int(11)');
        $table->addField('format', 'varchar(255)');
        $table->addField('name', 'varchar(255)');
        // index
        $table->addIndex('userid', 'index_userid');

        // юридические реквизиты клиентов (детали)
        $table = SQLObject_Config::Get()->addClass('XShopUserLegalData', 'shopuserlegaldata');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('legalid', 'int(11)');
        $table->addField('key', 'varchar(255)');
        $table->addField('name', 'varchar(255)');
        $table->addField('value', 'varchar(255)');
        // index
        $table->addIndex('legalid', 'index_legalid');

        // shop products
        $table = SQLObject_Config::Get()->addClass('XShopProduct', 'shopproduct');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('isbox', 'tinyint(1)'); // коробка ли это
        $table->addField('name', 'varchar(255)');
        $table->addField('name1', 'varchar(255)'); // дополнительное имя товара
        $table->addField('name2', 'varchar(255)'); // дополнительное имя товара
        $table->addField('description', 'text');
        $table->addField('tags', 'text');
        $table->addField('characteristics', 'text'); // характеристики товара
        $table->addField('image', 'varchar(255)');
        $table->addField('tmpimageurl', 'varchar(500)'); // юрл каритнок
        $table->addField('imagecrop', 'varchar(255)');
        $table->addField('price', 'decimal(15,2)');
        $table->addField('priceold', 'decimal(15,2)'); // Зачеркнутая цена
        $table->addField('currencyid', 'int(11)');
        $table->addField('categoryid', 'int(11)'); // категория
        $table->addField('brandid', 'int(11)'); // бренд
        $table->addField('model', 'varchar(255)'); // модель
        $table->addField('articul', 'varchar(255)'); // модель
        $table->addField('userid', 'int(11)'); // ссылка юзера (владельца товара, поставщика)
        $table->addField('top', 'tinyint(1)');
        $table->addField('rating', 'float');
        $table->addField('ratingcount', 'int(11)');
        $table->addField('viewed', 'int(11)'); // количество просмотров
        $table->addField('ordered', 'int(11)'); // количество заказов
        $table->addField('storaged', 'int(11)'); // количество на складе
        $table->addField('lastordered', 'datetime'); //дата последнего заказа
        $table->addField('divisibility', 'decimal(15,3)'); // дробимость
        $table->addField('unit', 'varchar(32)'); // единица измерения, по умолчанию шт.
        $table->addField('barcode', 'varchar(13)'); // штрих-код
        $table->addField('warranty', 'varchar(255)'); // информация о гарантии
        $table->addField('hidden', 'tinyint(1)'); // скрыт ли товар от просмотра
        $table->addField('hiddenold', 'tinyint(1)'); // cкрыт (резервное поле)
        $table->addField('deleted', 'tinyint(1)'); // удален ли товар
        $table->addField('sync', 'tinyint(1)'); // временное поле для синхронизации
        $table->addField('unsyncable', 'tinyint(1)'); // товар не подлежит синхронизации
        $table->addField('avail', 'tinyint(1)'); // наличие товара
        $table->addField('suppliered', 'tinyint(1)'); // наличие у любого поставщика
        $table->addField('availtext', 'varchar(255)'); // наличие товара (строка)
        $table->addField('seriesname', 'varchar(255)'); // имя серии
        $table->addField('url', 'varchar(100)'); // product url
        $table->addField('siteurl', 'varchar(100)'); // ссылка на сайт производителя
        $table->addField('collectionid', 'int(11)'); // коллекция
        $table->addField('length', 'varchar(32)');//длина
        $table->addField('width', 'varchar(32)');//ширина
        $table->addField('height', 'varchar(32)');//высота
        $table->addField('weight', 'varchar(32)');//вес
        $table->addField('unitbox', 'int(11)'); // количество в коробке
        $table->addField('discount', 'int(11)'); // скидка
        $table->addField('preorderDiscount', 'tinyint(1)');// скидка по предзаказу
        $table->addField('tax', 'tinyint(1)'); // это цены с НДС или нет
        $table->addField('payment', 'varchar(255)'); // условия оплаты
        $table->addField('delivery', 'varchar(255)'); // условия доставки
        $table->addField('denycomments', 'tinyint(1)'); // запретить комментирование
        $table->addField('descriptionshort', 'varchar(300)'); // краткое описание
        $table->addField('code1c', 'varchar(255)'); // Код 1С
        $table->addField('codesupplier', 'varchar(255)');  // код поставщика // @todo @deprecated ?
        $table->addField('share', 'varchar(255)');  // текст акция
        $table->addField('seodescription', 'varchar(255)'); // seo описание товара
        $table->addField('seotitle', 'varchar(255)'); // seo title у товара
        $table->addField('seoh1', 'varchar(255)'); // seo h1 title у товара
        $table->addField('seocontent', 'text'); // seo текст
        $table->addField('seokeywords', 'varchar(255)'); // seo ключевые слова
        $table->addField('iconid', 'int(11)');
        $table->addField('filedownload', 'varchar(255)'); // название файла, отправляемого при покупке
        $table->addField('supplierid', 'int(11)');
        $table->addField('udate', 'datetime');
        $table->addField('rrc', 'tinyint(1)'); // rrc или minretail цена
        $table->addField('cdate', 'datetime');
        $table->addField('imagegrouped', 'tinyint(1)'); // использовать картинку для группировки
        $table->addField('notdiscount', 'tinyint(1)'); // На этот товар не делается скидка
        $table->addField('maxdiscount', 'decimal(15,2)'); // Максимальный процент скидки
        for ($j = 1; $j <= 5; $j++) {
            $table->addField('price'.$j, 'decimal(15,2)'); // дополнительные уровни цен
        }
        /*try {
            $filter_count = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filter_count = 10;
        }
        for ($j = 1; $j <= $filter_count; $j++) {
            $table->addField('filter'.$j.'id', 'int(11)');
            $table->addField('filter'.$j.'value', 'varchar(255)');
            $table->addField('filter'.$j.'actual', 'tinyint(1)'); // характеристика в таблице
            $table->addField('filter'.$j.'use', 'tinyint(1)'); // доступен в фильтрах
            $table->addField('filter'.$j.'option', 'tinyint(1)'); // опция заказа
            $table->addField('filter'.$j.'markup', 'decimal(15,2)'); // наценка за опцию
        }*/
        for ($j = 1; $j <= 10; $j++) {
            $table->addField('category'.$j.'id', 'int(11)');
            // индексы
            $table->addIndex(array('category'.$j.'id', 'hidden'), 'category'.$j.'id');
        }

        $table->addField('linkkey', 'varchar(255)');
        $table->addField('source', 'varchar(32)'); // источник товара: склад, сетка, безлимит
        $table->addField('term', "enum('unlimited','day','month','year')"); // тип срока
        $table->addField('pricebase', 'decimal(15,2)'); // себестоимость товара
        $table->addField('pricesell', 'decimal(15,2)'); // цена товара в базовой валюте со скидками(цена продажи)
        $table->addField('datelifefrom', 'date'); // время жизни товара
        $table->addField('datelifeto', 'date');
        $table->addField('f_id', 'int(11)');
        // индексы
        $table->addIndex('price', 'price');
        $table->addIndex('currencyid', 'index_currencyid');
        $table->addIndex('url', 'url');
        $table->addIndex('avail', 'avail');
        $table->addIndex('url', 'url');
        $table->addIndex('linkkey', 'index_linkkey');
        $table->addIndex('articul', 'index_articul');
        $table->addIndex('seriesname', 'index_seriesname');
        $table->addIndex(
            array('avail','hidden','deleted','seriesname'),
            'index_seriesname_more'
        );
        $table->addIndex(
            array('avail','hidden','deleted','categoryid','datelifefrom','datelifeto'),
            'index_product_list_find'
        );
        $table->addIndex('brandid', 'index_brandid');
        $table->addIndex('code1c', 'index_code1c');

        // данные поставщиков по конкретному товару
        $table = SQLObject_Config::Get()->addClass('XShopProductSupplier', 'shopproductsupplier');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('productid', 'int(11)');
        $table->addField('supplierid', 'int(11)');
        $table->addField('code', 'varchar(32)');
        $table->addField('price', 'decimal(15,2)');
        $table->addField('article', 'varchar(32)');
        $table->addField('discount', 'int(11)');
        $table->addField('currencyid', 'int(11)');
        $table->addField('avail', 'tinyint(1)');
        $table->addField('availtext', 'varchar(16)');
        $table->addField('date', 'datetime');
        $table->addField('minretail', 'decimal(15,2)'); //мин розница
        $table->addField('minretail_cur_id', 'int(11)');
        $table->addField('recommretail', 'decimal(15,2)'); //рекомендуемая розница
        $table->addField('recommretail_cur_id', 'int(11)');
        $table->addField('comment', 'varchar(100)');
        // indexes
        $table->addIndex('supplierid', 'index_supplierid');
        $table->addIndex('productid', 'index_productid');
        $table->addIndex(array('code', 'supplierid'), 'index_codesupplier');
        $table->addIndex(array('productid', 'supplierid'), 'index_productsupplier');

        // временные ссылки для скачивания
        $table = SQLObject_Config::Get()->addClass('XShopDownloadURL', 'shopdownloadurl');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('file', 'varchar(255)');
        $table->addField('hash', 'varchar(255)');
        $table->addField('linkkey', 'varchar(255)');
        $table->addField('cdate', 'datetime');
        $table->addField('edate', 'datetime');
        // индексы
        $table->addIndex('linkkey', 'index_linkkey');
        $table->addIndex('hash', 'index_hash');

        // поставщики
        $table = SQLObject_Config::Get()->addClass('XShopSupplier', 'shopsupplier');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('description', 'text');
        $table->addField('contactid', 'int(11)');
        $table->addField('workflowid', 'int(11)');
        $table->addField('hidden', 'tinyint(1)');
        $table->addField('color', 'varchar(7)');
        $table->addField('availtext', 'varchar(255)');
        $table->addField('deliverytime', 'varchar(255)'); // время доставки от поставщика
        // indexes
        $table->addIndex('contactid', 'index_contactid');

        // shop product filters
        $table = SQLObject_Config::Get()->addClass('XShopProductFilter', 'shopproductfilter');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('hidden', 'tinyint(11)');
        $table->addField('filter', 'tinyint(1)');
        $table->addField('sort', 'int(11)');
        $table->addField(
            'type',
            "enum('interval','intervalselect','intervalslider','select','checkbox','radiobox','color','size')"
        );
        $table->addField('sorttype', 'tinyint(11)'); // 0 - string, 1 - number
        $table->addField('linkkey', 'varchar(255)');
        $table->addField('basicfilter', 'tinyint(1)');
        // индексы
        $table->addIndex('hidden', 'index_hidden');

        // shop product filter value
        $table = SQLObject_Config::Get()->addClass('XShopProductFilterValue', 'shopproductfiltervalue');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('productid', 'int(11)');
        $table->addField('filterid', 'int(11)');
        $table->addField('filtervalue', 'varchar(255)');
        $table->addField('filteractual', 'tinyint(1)'); // характеристика в таблице
        $table->addField('filteruse', 'tinyint(1)'); // доступен в фильтрах
        $table->addField('filteroption', 'tinyint(1)'); // опция заказа
        $table->addField('filtermarkup', 'decimal(15,2)'); // наценка за опцию
        // индексы
        $table->addIndexUnique(array('productid', 'filterid', 'filteruse', 'filtervalue'), 'index_productfiltervalue');
        $table->addIndexUnique(array('filtervalue', 'filterid', 'productid'), 'index_valuefilterproduct');

        // shop product images
        $table = SQLObject_Config::Get()->addClass('XShopImage', 'shopimage');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('productid', 'int(11)');
        $table->addField('file', 'varchar(255)');
        // индексы
        $table->addIndex('productid', 'index_productid');

        // shop product comment
        $table = SQLObject_Config::Get()->addClass('XShopProductComment', 'shopproductcomment');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('productid', 'int(11)');
        $table->addField('userid', 'int(11)');
        $table->addField('text', 'text');
        $table->addField('cdate', 'datetime');
        $table->addField('rating', 'int(11)');
        $table->addField('plus', 'text');
        $table->addField('minus', 'text');
        $table->addField('image', 'varchar(255)');
        $table->addField('username', 'varchar(255)');
        $table->addField('answer', 'text');
        // индексы
        $table->addIndex('userid', 'index_userid');
        $table->addIndex('productid', 'index_productid');

        // категории товаров
        $table = SQLObject_Config::Get()->addClass('XShopCategory', 'shopcategory');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('description', 'text');
        $table->addField('nameformula', 'text');
        $table->addField('image', 'varchar(255)');
        $table->addField('imagecrop', 'varchar(255)');
        $table->addField('parentid', 'int(11)');
        $table->addField('hidden', 'tinyint(1)'); // cкрытая категория
        $table->addField('hiddenold', 'tinyint(1)'); // cкрытая категория (резервное поле)
        $table->addField('sort', 'int(11)'); // порядок сортировки категорий
        $table->addField('showtype', 'varchar(255)');
        $table->addField('url', 'varchar(100)'); // category url
        $table->addField('productcount', 'int(11)'); // количетсво товаров в этой категории
        $table->addField('code1c', 'varchar(255)'); // Код 1С
        $table->addField('codesupplier', 'varchar(255)');  // код поставщика
        $table->addField('seodescription', 'varchar(255)'); // seo описание
        $table->addField('seotitle', 'varchar(255)'); // seo title
        $table->addField('seoh1', 'varchar(255)'); // seo h1 title у товара
        $table->addField('seocontent', 'text'); // seo текст
        $table->addField('seokeywords', 'varchar(255)'); // seo ключевые слова
        $table->addField('subdomain', 'varchar(100)'); // название поддомена
        $table->addField('sortdefault', 'varchar(255)'); // сортировка товаров по умолчанию
        $table->addField('color', 'varchar(16)'); // цвет
        $table->addField('linkkey', 'varchar(255)');
        $table->addField('logicclass', 'varchar(255)');
        $table->addField('level', 'int(3)'); // уровень вложености категории
        $table->addField('imageInModel', 'tinyint(1)'); // показывать изображение в модельном ряду
        // фильтры по умолчанию
        try {
            $filter_count = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filter_count = 10;
        }
        for ($j = 1; $j <= $filter_count; $j++) {
            $table->addField('filter'.$j.'id', 'int(11)');
        }
        // индексы
        $table->addIndex('url', 'index_url');
        $table->addIndex('productcount', 'index_productcount');
        $table->addIndex(array('parentid', 'hidden', 'sort', 'name'), 'index_parentid');
        $table->addIndex(array('subdomain', 'url'), 'index_subdomainurl');
        $table->addIndex(array('hidden'), 'index_hidden');
        $table->addIndex(array('linkkey'), 'index_linkkey');


        // shop brands
        $table = SQLObject_Config::Get()->addClass('XShopBrand', 'shopbrand');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('image', 'varchar(255)');
        $table->addField('url', 'varchar(100)'); // brand url
        $table->addField('showtype', "varchar(255)");
        $table->addField('siteurl', "varchar(255)"); // ссылка на сайт бренда
        $table->addField('top', "tinyint(1)"); // популярный бренд (на главную)
        $table->addField('description', "text"); // описание
        $table->addField('productcount', 'int(11)'); // количетсво товаров этого бренда
        $table->addField('seodescription', 'varchar(255)'); // seo описание
        $table->addField('seotitle', 'varchar(255)'); // seo title
        $table->addField('seoh1', 'varchar(255)'); // seo h1 title у товара
        $table->addField('seocontent', 'text'); // seo текст
        $table->addField('seokeywords', 'varchar(255)'); // seo ключевые слова
        $table->addField('country', 'varchar(100)'); //страна бренда
        $table->addField('hidden', 'tinyint(1)'); // скрытый или нет?
        $table->addField('linkkey', 'varchar(255)');
        $table->addField('code1c', 'varchar(255)');
        // индексы
        $table->addIndex('url', 'index_url');
        $table->addIndex('productcount', 'index_productcount');
        $table->addIndex('name', 'index_name');
        $table->addIndex('linkkey', 'index_linkkey');
        $table->addIndex(array('hidden', 'name'), 'index_hidden');

        // shop orders
        $table = SQLObject_Config::Get()->addClass('XShopOrder', 'shoporder');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('number', 'varchar(32)'); // номер заказа
        $table->addField('name', 'varchar(255)'); // имя заказа
        $table->addField('userid', 'int(11)'); // кто клиент
        $table->addField('clientmanagerid', 'int(11)'); // кто менеджер на стороне клиента
        $table->addField('managerid', 'int(11)'); // кто менеджер (assingnee)
        $table->addField('authorid', 'int(11)'); // кто автор (не редактируется)
        $table->addField('cdate', 'datetime'); // дата создания
        $table->addField('udate', 'datetime'); // дата обновления
        $table->addField('uuserid', 'int(11)'); // кто обновлял
        $table->addField('datetoyear', 'int(4)');
        $table->addField('datetomonth', 'int(2)');
        $table->addField('datetoday', 'int(2)');
        $table->addField('dateto', 'datetime');
        $table->addField('statusid', 'int(11)');
        $table->addField('categoryid', 'int(11)');
        $table->addField('clientname', 'varchar(255)');
        $table->addField('clientemail', 'varchar(255)');
        $table->addField('clientphone', 'varchar(255)');
        $table->addField('clientaddress', 'varchar(255)');
        $table->addField('clientcontacts', 'text');
        $table->addField('comments', 'text');
        $table->addField('sum', 'decimal(15,2)'); // полная сумма заказа, включая доставку, минус скидки, минус купоны
        $table->addField('currencyid', 'int(11)'); // валюта
        $table->addField('deliveryid', 'int(11)'); // тип доставки
        $table->addField('deliveryprice', 'decimal(15,2)'); // стоимость доставки
        $table->addField('paymentid', 'int(11)'); // способ оплаты
        $table->addField('discountid', 'int(11)'); // скидка
        $table->addField('discountsum', 'decimal(15,2)'); // сумма скидки
        $table->addField('hash', 'varchar(32)'); // md5 для track-url
        $table->addField('contractorid', 'int(11)'); // юридическое лицо
        $table->addField('deliverynote', 'text'); // накладная доставки
        $table->addField('sumpaid', 'decimal(15,2)'); // сумма оплаты заказа
        $table->addField('dateshipped', 'datetime'); // когда отгружен заказ
        $table->addField('dateclosed', 'datetime'); // дата когда заказ считается закрытым closed=1
        $table->addField('datedone', 'datetime'); // дата когда заказ считается выполненным done=1
        $table->addField('isshipped', 'tinyint(1)'); // отгружен ли товар (со склада)
        $table->addField('sourceid', 'int(11)'); // источник
        $table->addField('issue', 'tinyint(1)'); // это заказ или задача
        $table->addField('outcoming', 'tinyint(1)'); // это заказ на поставщика?
        $table->addField('parentid', 'int(11)'); // родительская задача
        $table->addField('parentstatusid', 'int(11)'); // статус родительской задачи
        $table->addField('resource', 'text'); // допустимые ресурсы
        $table->addField('estimate', 'decimal(15,2)'); // время на решение задачи
        $table->addField('money', 'decimal(15,2)'); // деньги на решение задачи
        $table->addField('sumbase', 'decimal(15,2)'); // сумма заказа в системной валюте
        $table->addField('linkkey', 'varchar(255)'); // ссылка
        $table->addField('ip', 'varchar(15)');
        $table->addField('forgift', 'tinyint(1)'); // для подарка
        $table->addField('nextid', 'int(11)'); // ID следующей задачи
        $table->addField('previd', 'int(11)'); // ID предыдущей задачи
        // Ключ, который говорит отправляли ли мы письмо, с просьюой отсавить отзывы по товарам с заказа
        $table->addField('send_mail_comment', 'tinyint(1)');
        $table->addField('priority', 'int(11)');
        $table->addField('type', 'varchar(255)');
        $table->addField('code1c', 'varchar(255)');
        $table->addField('deleted', 'tinyint(1)');
        // index
        $table->addIndex(array('userid', 'cdate'), 'index_useridcdate');
        $table->addIndex(array('udate'), 'index_udate');
        $table->addIndex(array('cdate'), 'index_udate');
        $table->addIndex(array('deleted'), 'index_deleted');
        $table->addIndex(array('parentid', 'parentstatusid'), 'index_parentstatus');
        $table->addIndex(array('type', 'deleted'), 'index_typedeleted');
        $table->addIndex('statusid', 'index_statusid');
        $table->addIndex('managerid', 'index_managerid');
        $table->addIndex('dateclosed', 'index_dateclosed');
        $table->addIndex('priority', 'index_priority');
        $table->addIndex('categoryid', 'index_categoryid');
        $table->addIndex('linkkey', 'index_linkkey');
        $table->addIndex('code1c', 'index_code1c');
        $table->addIndex(array('datetoyear', 'datetomonth', 'deleted', 'managerid'), 'index_datetobreak');

        // история изменения полей заказа
        $table = SQLObject_Config::Get()->addClass('XShopOrderChange', 'shoporderchange');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('orderid', 'int(11)');
        $table->addField('cdate', 'datetime');
        $table->addField('key', 'varchar(255)');
        $table->addField('value', 'varchar(255)');
        $table->addField('userid', 'int(11)');
        // indexes
        $table->addIndex('orderid', 'index_orderid');
        $table->addIndex(array('key', 'orderid'), 'index_keyorderid');

        $table = SQLObject_Config::Get()->addClass('XShopOrderContacts', 'shopordercontacts');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('orderid', 'int(11)');
        $table->addField('userid', 'int(11)');
        $table->addField('comment', 'varchar(255)');
        // indexes
        $table->addIndex(array('orderid', 'userid'), 'index_orderuser');

        // файлы-вложения (в заказ, в клиента)
        $table = SQLObject_Config::Get()->addClass('XShopFile', 'shopfile');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('key', 'varchar(255)');
        $table->addField('name', 'varchar(255)');
        $table->addField('file', 'varchar(255)');
        $table->addField('contenttype', 'varchar(255)');
        $table->addField('cdate', 'datetime');
        $table->addField('userid', 'int(11)');
        $table->addField('deleted', 'tinyint(1)');
        // indexes
        $table->addIndex(array('key', 'deleted', 'cdate'), 'index_keydeleted');
        $table->addIndex('file', 'index_hash');
        $table->addIndex('name', 'index_name');
        $table->addIndex(array('deleted'), 'index_deleted');

        // исполнители заказа
        $table = SQLObject_Config::Get()->addClass('XShopOrderEmployer', 'shoporderemployer');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('orderid', 'int(11)'); // заказ
        $table->addField('managerid', 'int(11)'); // сотрудник
        $table->addField('statusid', 'int(11)'); // для какого статуса (auto-assignee)
        $table->addField('role', 'varchar(255)');
        $table->addField('sum', 'decimal(15,2)');
        $table->addField('percent', 'decimal(15,2)');
        $table->addField('term', 'datetime');
        // index
        $table->addIndex(array('orderid', 'managerid'), 'index_ordermanager');
        $table->addIndex(array('managerid', 'term'), 'index_managerterm');

        // история изменения полей заказа
        $table = SQLObject_Config::Get()->addClass('XShopOrderLogView', 'shoporderlogview');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('orderid', 'int(11)');
        $table->addField('userid', 'int(11)');
        $table->addField('cdate', 'datetime');
        $table->addField('last', 'tinyint(1)');
        // индексы
        $table->addIndex(array('orderid', 'userid'), 'index_orderuser');

        // shop order category (workflow)
        $table = SQLObject_Config::Get()->addClass('XShopOrderCategory', 'shopordercategory');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('issue', 'int(11)'); // для задач или для заказов?
        $table->addField('type', 'varchar(255)');
        $table->addField('currencyid', 'int(11)'); // валюта по умолчанию
        $table->addField('productsDefault', 'varchar(255)'); // id продуктов по умолчанию
        $table->addField('default', 'tinyint(1)'); // по умолчанию для новых заказов и задач
        $table->addField('hidden', 'tinyint(1)'); // скрытость
        $table->addField('noautodateto', 'tinyint(1)'); // не устанавливать время до автоматичски
        $table->addField('term', 'int(11)'); // общий срок бизнес процесса (в днях)
        $table->addField('issuename', 'varchar(255)'); // имя для задач по умолчанию
        $table->addField('projectid', 'int(11)'); // проект для задач по умолчанию
        $table->addField('managerid', 'int(11)'); // менеджер для задач по умолчанию
        $table->addField('outcoming', 'tinyint(1)');
        $table->addField('changeType', 'tinyint(1)'); // флаг, указывающий что был изменен тип БП
        $table->addField('showOrderMenu', 'tinyint(1)'); // показывать ил кнопки печать / текст заказа
        $table->addField('keywords', 'text'); // ключевые слова для определения БП
        $table->addField('colorMenu', 'varchar(10)'); // цвет шапки меню
        // индексы
        $table->addIndex(array('hidden', 'name'), 'index_hiddenname');
        $table->addIndex('name', 'index_name'); // индекс для сортировки

        // типы бизнес-процессов
        $table = SQLObject_Config::Get()->addClass('XShopWorkflowType', 'shopworkflowtype');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('multiplename', 'varchar(255)');
        $table->addField('icon', 'varchar(255)');
        $table->addField('type', 'varchar(255)');
        $table->addField('typeaddpage', 'varchar(255)');
        $table->addField('contentId', 'varchar(255)');
        $table->addField('calendarShow', 'tinyint(1)');
        // indexes
        $table->addIndex('type', 'index_type');
        $table->addIndex('name', 'index_name');

        // блоки-структура заказов
        $table = SQLObject_Config::Get()->addClass(
            'XShopWorkflowStatusStructureBlock',
            'shopworkflowstatusstructureblock'
        );
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('statusid', 'int(11)');
        $table->addField('structureid', 'int(11)');
        $table->addField('blockid', 'int(11)');
        $table->addField('sort', 'int(11)');
        // indexes
        $table->addIndex('statusid', 'index_statusid');
        $table->addIndex('structureid', 'index_structureid');
        $table->addIndex('blockid', 'index_blockid');
        $table->addIndex('sort', 'index_sort');

        // блоки заказов
        $table = SQLObject_Config::Get()->addClass('XShopWorkflowStatusBlock', 'shopworkflowstatusblock');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('contentid', 'varchar(255)');
        $table->addField('priority', 'int(11)');
        // indexes
        $table->addIndex('name', 'index_name');

        // shop order/user source
        $table = SQLObject_Config::Get()->addClass('XShopSource', 'shopsource');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('address', 'varchar(255)');
        // indexes
        $table->addIndex('name', 'index_name');

        // кастомное меню для бизнес-процесса
        $table = SQLObject_Config::Get()->addClass('XShopWorkflowMenu', 'shopworkflowmenu');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('linkkey', 'varchar(255)');
        $table->addField('sort', 'int(11)');
        $table->addField('workflowid', 'int(11)');
        // indexes
        $table->addIndex('name', 'index_name');
        $table->addIndex('sort', 'index_sort');
        $table->addIndex('linkkey', 'index_linkkey');
        $table->addIndex('workflowid', 'index_workflowid');

        // shop order status
        $table = SQLObject_Config::Get()->addClass('XShopOrderStatus', 'shoporderstatus');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('message', 'text'); // сообщение по email
        $table->addField('messageadmin', 'text'); // сообщение по email для админа
        $table->addField('sms', 'text'); // сообщение по sms
        $table->addField('smsadmin', 'text'); // сообщение по sms для админа
        $table->addField('smslogicclass', 'varchar(255)'); // логический класс для текста смс
        $table->addField('default', 'tinyint(1)'); // базовый или нет, заказ оформляется в базовый статус
        $table->addField('payed', 'tinyint(1)');
        $table->addField('saled', 'tinyint(1)');
        $table->addField('downloadable', 'tinyint(1)');
        $table->addField('sort', 'int(11)'); // сортировка
        $table->addField('priority', 'int(11)'); // приоритет перекрытия
        $table->addField('linkkey', 'varchar(255)');
        $table->addField('categoryid', 'int(11)'); // статус только для категории заказа
        $table->addField('content', 'text'); // описание статуса
        $table->addField('x', 'int(11)');
        $table->addField('y', 'int(11)');
        $table->addField('width', 'int(11)');
        $table->addField('height', 'int(11)');
        $table->addField('colour', 'varchar(7)'); // цвет строки и ячейки
        $table->addField('term', 'int(11)'); // срок статуса
        $table->addField('termperiod', "enum('hour','day','week','month','year')"); // срок статуса
        $table->addField('processor', 'varchar(255)'); // обработчик для фона
        $table->addField('processorform', 'varchar(255)'); // обработчик для формы
        $table->addField('roleid', 'int(11)'); // ответственная роль
        $table->addField('managerid', 'int(11)'); // конкретный ответственный
        $table->addField('cnt', 'int(11)'); // сколько на данном этапе
        $table->addField('cntlast', 'int(11)'); // сколько на данном этапе было
        $table->addField('onlyauto', 'tinyint(1)'); // этап нельзя выбрать вручную
        $table->addField('onlyissue', 'tinyint(1)'); // проверка на выполнение задач
        $table->addField('jumpmanager', 'tinyint(1)'); // прыгать ответственным
        $table->addField('prepayed', 'tinyint(1)');
        $table->addField('notifysmsclient', 'tinyint(1)');
        $table->addField('notifysmsadmin', 'tinyint(1)');
        $table->addField('notifysmsmanager', 'tinyint(1)');
        $table->addField('notifyemailclient', 'tinyint(1)');
        $table->addField('notifyemailadmin', 'tinyint(1)');
        $table->addField('notifyemailmanager', 'tinyint(1)');
        $table->addField('needcontent', 'tinyint(1)');
        $table->addField('needdocument', 'tinyint(1)');
        $table->addField('closed', 'tinyint(1)'); // закрыта
        $table->addField('done', 'tinyint(1)'); // ожидает проверки
        $table->addField('shipped', 'tinyint(1)'); // отгружена
        $table->addField('cancelOrderSupplier', 'tinyint(1)');
        $table->addField('createOrderSupplier', 'tinyint(1)');
        $table->addField('createXml', 'tinyint(1)');
        $table->addField('createCsv', 'tinyint(1)');
        $table->addField('autorepeat', 'tinyint(1)');
        $table->addField('nextworkflowid', 'int(11)');
        $table->addField('nextstatusid', 'int(11)');
        for ($j = 1; $j <= 30; $j++) {
            $table->addField('subworkflow'.$j, 'int(11)');
            $table->addField('subworkflow'.$j.'name', 'varchar(255)');
            $table->addField('subworkflow'.$j.'date', 'int(3)');
            $table->addField('subworkflow'.$j.'description', 'text');
        }
        $table->addField('autonextstatusid', 'int(11)');
        $table->addField('no_communication', 'int(11)'); // период отсутствия комуникации в часах
        $table->addField('no_communication_call', 'int(11)'); // период отсутствия комуникации через звонки в часах
        $table->addField('no_communication_email', 'int(11)'); // период отсутствия комуникации звонки в по телефону
        // переносить задачу на следующий день, если она не готова (0, start, end)
        $table->addField('nextdate', 'varchar(20)');
        // indexes
        $table->addIndex('default', 'index_default');
        $table->addIndex('saled', 'index_saled');
        $table->addIndex('linkkey', 'index_linkkey');
        $table->addIndex(array('sort', 'name'), 'index_sort');
        $table->addIndex(array('categoryid', 'sort'), 'index_categoryid');
        $table->addIndex(array('categoryid', 'closed'), 'index_categoryidclosed');

        // переходы между статусами (визуальные стрелки)
        $table = SQLObject_Config::Get()->addClass('XShopOrderStatusChange', 'shoporderstatuschange');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('categoryid', 'int(11)');
        $table->addField('elementfromid', 'int(11)');
        $table->addField('elementtoid', 'int(11)');
        // indexes
        $table->addIndex(array('elementfromid', 'elementtoid'), 'index_fromto');
        $table->addIndex(array('categoryid'), 'index_categoryid');

        $table = SQLObject_Config::Get()->addClass('XShopOrderStatusActionBlock', 'shoporderstatusactionblock');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('contentid', 'varchar(255)');
        $table->addField('description', 'varchar(255)');
        $table->addField('deleted', 'tinyint(1)'); // флаг при build
        // indexes
        $table->addIndex('name', 'index_name');

        $table = SQLObject_Config::Get()->addClass(
            'XShopOrderStatusActionBlockStructure',
            'shoporderstatusactionblockstructure'
        );
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('contentid', 'varchar(255)');
        $table->addField('statusid', 'int(11)');
        $table->addField('sort', 'int(11)');
        $table->addField('data', 'longtext');
        // indexes
        $table->addIndex('sort', 'index_sort');
        $table->addIndex('contentid', 'index_contentid');
        $table->addIndex('statusid', 'index_statusid');

        // shop order items
        $table = SQLObject_Config::Get()->addClass('XShopOrderProduct', 'shoporderproduct');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('orderid', 'int(11)');
        $table->addField('productid', 'int(11)');
        $table->addField('productcount', 'decimal(15,3)');
        $table->addField('productname', 'varchar(255)');
        $table->addField('productprice', 'decimal(15,2)');
        $table->addField('discountpercent', 'decimal(15,2)');
        $table->addField('producttax', 'tinyint(1)');
        $table->addField('currencyid', 'int(11)');
        $table->addField('serial', 'varchar(255)');
        $table->addField('warranty', 'varchar(255)');
        $table->addField('categoryname', 'varchar(255)');
        $table->addField('comment', 'text'); // примечание админа
        $table->addField('statusid', 'int(11)'); // строчка статуса
        $table->addField('storageid', 'int(11)'); // склад для списывания
        $table->addField('supplierid', 'int(11)'); // ссылка на выбранного поставщика
        $table->addField('params', 'varchar(255)'); // параметры заказа (скрытое поле)
        $table->addField('datefrom', 'datetime'); // сетка занятости: от
        $table->addField('dateto', 'datetime'); // сетка занятости: до
        $table->addField('linkkey', 'varchar(255)'); // связь
        $table->addField('sortable', 'int(11)'); // Сортировка
        $table->addField('sync', 'tinyint(1)');
        $table->addField('startprice', 'decimal(15,2)'); // цена товара на момент покупки без акционной скидки
        // индексы
        $table->addIndex('orderid', 'index_orderid');
        $table->addIndex('productid', 'index_productid');

        // связи товаров что заказывали вместе (в одном заказе) / затем из этих товаров формируем списки "Рекомендуем"
        $table = SQLObject_Config::Get()->addClass('XProduct2OrderedProduct', 'product2orderedproduct');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('productid', 'int(11)');
        $table->addField('orderedproductid', 'int(11)');
        $table->addField('orderedproductcode1c', 'varchar(255)');
        $table->addField('productcount', 'int(11)');
        $table->addField('deleted', 'int(11)'); // если админ удалил из списка рекомендуемых
        // индексы
        $table->addIndex('productid', 'index_productid');

        // связи рекомендованных товаров, что бы не находить кружными путями через списки продуктов, заполняем в кроне
        $table = SQLObject_Config::Get()->addClass('XProduct2RelatedProduct', 'product2relatedproduct');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('productid', 'int(11)');
        $table->addField('relatedproductid', 'int(11)');
        $table->addField('sync', 'tinyint(1)');
        // индексы
        $table->addIndex(array('productid','relatedproductid'), 'index_productid');
        $table->addIndex('sync', 'index_sync');

        // скидки
        $table = SQLObject_Config::Get()->addClass('XShopDiscount', 'shopdiscount');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('value', 'decimal(15,2)'); // процент скидки или сумма скидки в системной валюте
        $table->addField('type', "enum('percent','value')"); // скидка в процентах или конкретное значение
        $table->addField('minstartsum', 'int(11)'); // начиная с какой суммы применяется
        $table->addField('currencyid', 'int(11)'); // валюта
        // indexes
        $table->addIndex('name', 'index_name');

        // история просмотра товаров пользователями
        $table = SQLObject_Config::Get()->addClass('XShopProductView', 'shopproductview');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('productid', 'int(11)');
        $table->addField('userid', 'int(11)');
        $table->addField('sessionid', 'varchar(32)');
        $table->addField('ip', 'varchar(15)');
        $table->addField('cdate', 'datetime');
        // индексы
        $table->addIndex('cdate', 'index_cdate');
        $table->addIndex('productid', 'index_productid');
        $table->addIndex('userid', 'index_userid');

        // shop product views hourly
        // временная таблица в которую пишутся данные, а потом раз в час переносятся в
        // основную shopproductview. Сделано исключительно ради производительности.
        // shopproductviewhour специально без индексов
        $table = SQLObject_Config::Get()->addClass('XShopProductViewHour', 'shopproductviewhour');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('productid', 'int(11)');
        $table->addField('userid', 'int(11)');
        $table->addField('sessionid', 'varchar(32)');
        $table->addField('ip', 'varchar(15)');
        $table->addField('cdate', 'datetime');

        // история изменений товаров
        $table = SQLObject_Config::Get()->addClass('XShopProductChange', 'shopproductchange');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('productid', 'int(11)');
        $table->addField('userid', 'int(11)');
        $table->addField('cdate', 'datetime');
        $table->addField('key', 'varchar(32)');
        $table->addField('valueold', 'text');
        $table->addField('valuenew', 'text');
        // индексы
        $table->addIndex('productid', 'index_productid');

        // search log
        $table = SQLObject_Config::Get()->addClass('XShopSearchLog', 'shopsearch');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('sid', 'varchar(32)');
        $table->addField('userid', 'int(11)');
        $table->addField('query', 'varchar(255)');
        $table->addField('countresult', 'int(11)');
        // indexes
        $table->addIndex('sid', 'index_sid');
        $table->addIndex('query', 'index_query');

        // шаблон комментариев
        $table = SQLObject_Config::Get()->addClass('XShopCommentTemplate', 'shopcommenttemplate');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('text', 'text');
        // indexes
        $table->addIndex('name', 'index_name');

        $table = SQLObject_Config::Get()->addClass('XShopNotification', 'shopnotification');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('userid', 'int(11)');
        $table->addField('commentid', 'int(11)');
        $table->addField('orderid', 'int(11)');
        // indexes
        $table->addIndex('userid', 'index_userid');

        // basket - корзина
        $table = SQLObject_Config::Get()->addClass('XShopBasket', 'shopbasket');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('sid', 'varchar(32)');
        $table->addField('userid', 'int(11)'); // for issue #34973 - smart basket
        $table->addField('productid', 'int(11)');
        $table->addField('actionsetid', 'int(11)'); // входит в набор
        $table->addField('actionsetcount', 'int(11)'); // количество наборов
        $table->addField('actionsetprice', 'decimal(15,3)'); // (если товар из набора) цена в корзине
        $table->addField('productcount', 'decimal(15,3)');
        $table->addField('productprice', 'decimal(15,3)'); // цена в корзине
        try {
            $filter_count = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filter_count = 10;
        }
        for ($j = 1; $j <= $filter_count; $j++) {
            $table->addField('filter'.$j.'id', 'int(11)');
            $table->addField('filter'.$j.'value', 'varchar(255)');
            $table->addField('filter'.$j.'markup', 'decimal(15,2)');//наценка за опцию
        }
        $table->addField('params', 'varchar(255)'); // параметры заказа (скрытое поле)
        $table->addField('datefrom', 'datetime'); // сетка занятости: от
        $table->addField('dateto', 'datetime'); // сетка занятости: до
        // индексы
        $table->addIndex(array('sid', 'userid'), 'index_sid_userid');

        // сравнение товаров
        $table = SQLObject_Config::Get()->addClass('XShopCompare', 'shopcompare');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('sid', 'varchar(32)');
        $table->addField('productid', 'int(11)');
        $table->addField('categoryid', 'int(11)');
        // индексы
        $table->addIndex('sid', 'index_sid');
        $table->addIndex('cdate', 'index_cdate');

        // shop currency - валюта
        $table = SQLObject_Config::Get()->addClass('XShopCurrency', 'shopcurrency');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)'); // имя валюты
        $table->addField('symbol', 'varchar(32)'); // значок валюты
        $table->addField('rate', 'float'); // курс относительно базовой
        $table->addField('default', 'tinyint(1)'); // базовая или нет, заказ оформляется в базовой
        $table->addField('hidden', 'tinyint(1)'); // скрыта или нет
        $table->addField('sort', 'int(11)'); // Порядок сортировки
        $table->addField('logicclass', 'varchar(255)'); // класс авто-обновления
        $table->addField('percent', 'decimal(15,3)'); // процент надбавки
        $table->addField('linkkey', 'varchar(255)');
        // индексы
        $table->addIndex('default', 'index_default');
        $table->addIndex('linkkey', 'index_linkkey');

        // юридические лица
        $table = SQLObject_Config::Get()->addClass('XShopContractor', 'shopcontractor');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)'); // название
        $table->addField('details', 'text'); // юридические реквизиты
        $table->addField('tax', 'float'); // значение НДС (%)
        $table->addField('active', 'tinyint(1)');
        $table->addField('default', 'tinyint(1)');
        $table->addField('linkkey', 'varchar(255)');
        $table->addField('customfield1', 'text');
        $table->addField('customfield2', 'text');
        $table->addField('customfield3', 'text');
        $table->addField('customfield4', 'text');
        $table->addField('customfield5', 'text');
        $table->addField('customfield6', 'text');
        $table->addField('customfield7', 'text');
        $table->addField('customfield8', 'text');
        $table->addField('customfield9', 'text');
        $table->addField('customfield10', 'text');
        // indexes
        $table->addIndex(array('active', 'name'), 'index_activename');
        $table->addIndex('name', 'index_name');

        // shop price places exports
        $table = SQLObject_Config::Get()->addClass('XShopExportPlace', 'shopplace');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('logicclass', 'varchar(255)');
        // indexes
        $table->addIndex('name', 'index_name');

        // shop price places exports
        $table = SQLObject_Config::Get()->addClass('XShopExportPlaceCategory', 'shopplacecategory');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('placeid', 'int(11)');
        $table->addField('categoryid', 'int(11)');
        $table->addField('productid', 'int(11)');
        $table->addField('disable', 'tinyint(1)');
        // индексы
        $table->addIndex(array('productid', 'placeid'), 'index_productidplaceid');

        // настраиваемые колонки таблиц
        $table = SQLObject_Config::Get()->addClass('XShopTableColumn', 'shoptablecolumn');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('userid', 'int(11)');
        $table->addField('key', 'varchar(255)');
        $table->addField('visible', 'tinyint(1)');
        $table->addField('datasource', 'varchar(255)');
        // индексы
        $table->addIndex('datasource', 'index_datasource');
        $table->addIndex(array('userid', 'datasource'), 'index_useridatasource');

        // настраиваемые блоки (~MDK)
        $table = SQLObject_Config::Get()->addClass('XShopBlock', 'shopblock');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('active', 'tinyint(1)');
        $table->addField('contentid', 'varchar(255)');
        $table->addField('system', 'tinyint(1)'); // системный
        $table->addField('position', 'varchar(255)'); // редактируемая позиция
        $table->addField('positionsort', 'int(11)'); // сортировка в позиции
        $table->addField('linkkey', 'varchar(255)');
        // индексы
        $table->addIndex(array('active'), 'index_active');
        $table->addIndex(array('linkkey'), 'index_linkkey');

        // shop text pages
        $table = SQLObject_Config::Get()->addClass('XShopTextPage', 'shoptextpage');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('btnname', 'varchar(255)');
        $table->addField('image', 'varchar(255)');
        $table->addField('content', 'text');
        $table->addField('parentid', 'int(11)');
        $table->addField('logicclass', 'varchar(255)');
        $table->addField('sort', 'int(11)');
        $table->addField('hidden', 'tinyint(1)');
        $table->addField('main', 'tinyint(1)');
        $table->addField('url', 'varchar(100)'); // page url
        $table->addField('key', 'varchar(255)'); // key
        $table->addField('seodescription', 'varchar(255)'); // seo описание
        $table->addField('seotitle', 'varchar(255)'); // seo title
        $table->addField('seoh1', 'varchar(255)'); // seo h1 title у товара
        $table->addField('seocontent', 'text'); // seo текст
        $table->addField('seokeywords', 'varchar(255)'); // seo ключевые слова
        $table->addField('linkkey', 'varchar(255)');
        // индексы
        $table->addIndex('url', 'index_url');
        $table->addIndex('linkkey', 'index_linkkey');
        $table->addIndex(array('parentid', 'hidden', 'sort', 'name'), 'index_parent');

        // shop settings
        $table = SQLObject_Config::Get()->addClass('XShopSettings', 'shopsettings');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('key', 'varchar(255)');
        $table->addField('name', 'varchar(255)');
        $table->addField('value', 'text');
        $table->addField('type', 'varchar(255)');
        $table->addField('tabname', 'varchar(255)');
        $table->addField('description', 'varchar(255)');
        // индексы
        $table->addIndexUnique('key', 'index_key');
        $table->addIndex('tabname', 'index_tabname');

        // shop news
        $table = SQLObject_Config::Get()->addClass('XShopNews', 'shopnews');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('hidden', 'tinyint(1)');
        $table->addField('name', 'varchar(255)');
        $table->addField('image', 'varchar(255)');
        $table->addField('contentpreview', 'text');
        $table->addField('content', 'longtext');
        $table->addField('productid', 'int(11)');
        $table->addField('categoryid', 'int(11)');
        $table->addField('brandid', 'int(11)');
        $table->addField('url', 'varchar(255)');
        $table->addField('seodescription', 'varchar(255)'); // seo описание
        $table->addField('seotitle', 'varchar(255)'); // seo title
        $table->addField('seoh1', 'varchar(255)'); // seo h1 title у товара
        $table->addField('seocontent', 'text'); // seo текст
        $table->addField('seokeywords', 'varchar(255)'); // seo ключевые слова
        // индексы
        $table->addIndex('productid', 'index_productid');
        $table->addIndex(array('hidden', 'cdate'), 'index_hidden');

        // shop gallery
        $table = SQLObject_Config::Get()->addClass('XShopGallery', 'shopgallery');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('hidden', 'tinyint(1)');
        $table->addField('name', 'varchar(255)');
        $table->addField('sort', 'int(11)');
        $table->addField('image', 'varchar(255)');
        $table->addField('content', 'longtext');
        $table->addField('url', 'varchar(255)');
        $table->addField('album', 'varchar(255)');
        $table->addField('seodescription', 'varchar(255)'); // seo описание
        $table->addField('seotitle', 'varchar(255)'); // seo title
        $table->addField('seocontent', 'text'); // seo текст
        $table->addField('seoh1', 'varchar(255)'); // seo h1 title у товара
        $table->addField('seokeywords', 'varchar(255)'); // seo ключевые слова
        // индексы
        $table->addIndex('url', 'index_url');
        $table->addIndex(array('hidden', 'cdate'), 'index_hidden');

        // shop product list
        $table = SQLObject_Config::Get()->addClass('XShopProductList', 'shopproductlist');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('nameshort', 'varchar(255)');
        $table->addField('showinmain', 'tinyint(1)');
        $table->addField('linkkey', 'varchar(255)'); // ключ-привязка
        $table->addField('hidden', 'tinyint(1)');
        $table->addField('showtype', 'varchar(255)');
        $table->addField('autoplay', 'tinyint(1)');
        $table->addField('logicclass', 'varchar(255)');
        $table->addField('setimage', 'varchar(255)'); // изображение для списка типа набор
        // индексы
        $table->addIndex('linkkey', 'index_linkkey');
        $table->addIndex('hidden', 'index_hidden');
        $table->addIndex('showinmain', 'index_showinmain');

        // shop product-to-list
        $table = SQLObject_Config::Get()->addClass('XShopProduct2List', 'shopproduct2list');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('productid', 'varchar(255)');
        $table->addField('listid', 'int(11)');
        // индексы
        $table->addIndex('listid', 'index_listid');
        $table->addIndex('productid', 'index_productid');

        // акционные наборы
        $table = SQLObject_Config::Get()->addClass('XShopActionSet', 'shopactionset');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('productid', 'int(11)'); // основной товар набора к которому привязаны остальные
        $table->addField('discount', 'int(11)'); // скидка на основной товар
        $table->addField('name', 'varchar(255)');
        $table->addField('hidden', 'tinyint(1)');
        // индексы
        $table->addIndex(array('productid','hidden'), 'index_productid_hidden');

        $table = SQLObject_Config::Get()->addClass('XProduct2ActionSet', 'product2actionset');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('actionid', 'int(11)');
        $table->addField('productid', 'int(11)');
        $table->addField('discount', 'int(11)'); // скидка в процентах
        // индексы
        $table->addIndex(array('actionid','productid'), 'index_actionid_productid');

        // для рекомендации товаров со связанных категорий
        $table = SQLObject_Config::Get()->addClass('XShopReletedCategory', 'shopreletedcategory');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('categoryid', 'int(11)');
        $table->addField('reletedcategoryid', 'int(11)');
        // индексы
        $table->addIndex('categoryid', 'index_categoryid');
        $table->addIndex('reletedcategoryid', 'index_reletedcategoryid');

        // shop callback
        $table = SQLObject_Config::Get()->addClass('XShopCallBack', 'shopcallback');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('phone', 'varchar(255)');
        $table->addField('cdate', 'datetime');
        $table->addField('answer', 'varchar(255)');
        $table->addField('done', 'tinyint(1)');
        $table->addField('userid', 'int(11)');
        $table->addField('comment', 'text');
        $table->addField('url', 'text');
        $table->addField('linkkey', 'varchar(255)');
        // index
        $table->addIndex('userid', 'index_userid');

        // shop feedback
        $table = SQLObject_Config::Get()->addClass('XShopFeedback', 'shopfeedback');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('phone', 'varchar(255)');
        $table->addField('cdate', 'datetime');
        $table->addField('email', 'varchar(255)');
        $table->addField('message', 'varchar(255)');
        $table->addField('done', 'tinyint(1)');
        $table->addField('userid', 'int(11)');
        $table->addField('pageurl', 'varchar(255)');
        // index
        $table->addIndex('userid', 'index_userid');

        // shop faq
        $table = SQLObject_Config::Get()->addClass('XShopFaq', 'shopfaq');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('question', 'varchar(1000)');
        $table->addField('answer', 'varchar(2000)');
        $table->addField('cdate', 'datetime');
        $table->addField('userid', 'varchar(255)');
        $table->addField('linkkey', 'varchar(255)');
        // индексы
        $table->addIndex(array('question', 'answer'), true);
        $table->addIndex(array('linkkey'), 'index_linkkey');

        // shop timework
        $table = SQLObject_Config::Get()->addClass('XShopTimework', 'shoptimework');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('datefrom', 'datetime'); // дата старта
        $table->addField('dateto', 'datetime'); // дата завершения
        $table->addField('comment', 'text');
        // indexes
        $table->addIndex(array('datefrom', 'dateto'), 'index_dates');

        // shop delivery
        $table = SQLObject_Config::Get()->addClass('XShopDelivery', 'shopdelivery');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('description', 'text');
        $table->addField('image', 'varchar(255)');
        $table->addField('price', 'decimal(15,2)');
        $table->addField('currencyid', 'int(11)');
        $table->addField('sort', 'int(11)');
        $table->addField('default', 'tinyint(1)');
        $table->addField('needcity', 'tinyint(1)'); // необходимо указать город при оформлении заказа
        $table->addField('needaddress', 'tinyint(1)'); // необходимо указать адрес при оформлении заказа
        $table->addField('needcountry', 'tinyint(1)'); // необходимо указать страну при оформлении заказа
        $table->addField('paydelivery', 'tinyint(1)'); // учет доставки в сумму заказа
        $table->addField('logicclass', 'varchar(255)');
        // indexes
        $table->addIndex(array('sort', 'name'), 'index_sortname');

        // shop banner
        $table = SQLObject_Config::Get()->addClass('XShopBanner', 'shopbanner');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('image', 'varchar(255)');
        $table->addField('url', 'varchar(500)');
        $table->addField('hidden', 'tinyint(1)');
        $table->addField('place', 'varchar(255)');
        $table->addField('categoryid', 'int(11)');
        $table->addField('sort', 'int(11)');
        $table->addField('comment', 'text');
        $table->addField('linkkey', 'varchar(255)');
        $table->addField('pageinterval', 'varchar(255)');
        $table->addField('sdate', 'datetime');
        $table->addField('edate', 'datetime');
        // indexes
        $table->addIndex(array('hidden', 'sort'), 'index_hidden');

        // shop banner statistics
        $table = SQLObject_Config::Get()->addClass('XShopBannerStatistics', 'shopbannerstatistic');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('bannerid', 'int(11)');
        $table->addField('userid', 'int(11)');
        $table->addField('sessionid', 'varchar(32)');
        $table->addField('ip', 'varchar(15)');
        $table->addField('cdate', 'datetime');
        // index
        $table->addIndex('bannerid', 'index_bannerid');

        // shop logo
        $table = SQLObject_Config::Get()->addClass('XShopLogo', 'shoplogo');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('sdate', 'datetime'); // дата старта
        $table->addField('edate', 'datetime'); // дата завершения
        $table->addField('name', 'varchar(255)');
        $table->addField('file', 'varchar(255)');
        $table->addField('default', 'tinyint(1)');
        // индексы
        $table->addIndex(array('sdate', 'edate'), 'index_dates');

        // shop payment - способы оплаты
        $table = SQLObject_Config::Get()->addClass('XShopPayment', 'shoppayment');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('description', 'text');
        $table->addField('image', 'varchar(255)');
        $table->addField('deliveryid', 'int(11)');
        $table->addField('hidden', 'tinyint(1)');
        $table->addField('default', 'tinyint(1)');
        $table->addField('contentid', 'varchar(255)'); // контент системы оплаты
        // indexes
        $table->addIndex(array('hidden', 'name'), 'index_hiddenname');

        // shop payment - способы оплаты ???
        $table = SQLObject_Config::Get()->addClass('XShopPaymentResult', 'shoppaymentresult');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('amount', 'decimal(15,2)');
        $table->addField('orderid', 'int(11)');
        $table->addField('status', 'varchar(255)');
        // indexes
        $table->addIndex('orderid', 'index_orderid');

        // shop products notice of availability
        $table = SQLObject_Config::Get()->addClass(
            'XShopProductsNoticeOfAvailability',
            'shopproductsnoticeofavailability'
        );
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('productid', 'int(11)'); // id товара
        $table->addField('name', 'varchar(100)'); // имя
        $table->addField('email', 'varchar(100)'); // e-mail
        $table->addField('cdate', 'datetime'); // дата
        $table->addField('senddate', 'datetime'); // дата отправки
        $table->addField('status', 'tinyint(1)'); // отправлень сообщение или нет
        // indexes
        $table->addIndex('productid', 'index_productid');

        // отзывы о магазине (Гостевая гнига)
        $table = SQLObject_Config::Get()->addClass('XShopGuestBook', 'shopguestbook');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('userid', 'int(11)');
        $table->addField('cdate', 'datetime'); // дата отзыва
        $table->addField('text', 'text'); //текст сообщения
        $table->addField('done', 'tinyint(1)'); // статус отзыва ( 0 - не просмотрен модератором, 1 - просмотрен)
        $table->addField('name', 'varchar(255)');
        $table->addField('image', 'varchar(255)');
        $table->addField('linkkey', 'varchar(255)');
        $table->addField('answer', 'text');
        // indexes
        $table->addIndex(array('done', 'cdate'), 'index_donecdate');

        // задания по заливке базы из XLS
        $table = SQLObject_Config::Get()->addClass('XShopImport', 'shopimport');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('pdate', 'datetime');
        $table->addField('userid', 'int(11)');
        $table->addField('file', 'varchar(255)');
        $table->addField('comment', 'text');
        $table->addField('trycnt', 'int(3)');
        // индексы
        $table->addIndex('pdate', 'index_pdate');

        // задания по заливке базы из XLS
        $table = SQLObject_Config::Get()->addClass('XShopImportOrder', 'shopimportorder');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('pdate', 'datetime');
        $table->addField('userid', 'int(11)');
        $table->addField('file', 'varchar(255)');
        $table->addField('comment', 'text');
        $table->addField('trycnt', 'int(3)');
        // индексы
        $table->addIndex('pdate', 'index_pdate');

        // задания по заливке базы из XLS
        $table = SQLObject_Config::Get()->addClass('XShopExport', 'shopexport');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('pdate', 'datetime');
        $table->addField('userid', 'int(11)');
        $table->addField('categoryid', 'int(11)');
        $table->addField('comment', 'text');
        $table->addField('emails', 'text');
        // индексы
        $table->addIndex('pdate', 'index_pdate');

        // обмен контактами XLS
        $table = SQLObject_Config::Get()->addClass('XShopExportContacts', 'shopexportcontacts');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('pdate', 'datetime');
        $table->addField('userid', 'int(11)');
        $table->addField('companyname', 'varchar(255)');
        $table->addField('groupid', 'int(11)');
        $table->addField('comment', 'text');
        $table->addField('emails', 'text');
        // индексы
        $table->addIndex('pdate', 'index_pdate');

        $table = SQLObject_Config::Get()->addClass('XShopImportContacts', 'shopimportcontacts');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('pdate', 'datetime');
        $table->addField('userid', 'int(11)');
        $table->addField('file', 'varchar(255)');
        $table->addField('comment', 'text');
        // индексы
        $table->addIndex('pdate', 'index_pdate');

        // обмен SEO XLS
        $table = SQLObject_Config::Get()->addClass('XShopExportTask', 'shopexporttask');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('pdate', 'datetime');
        $table->addField('userid', 'int(11)');
        $table->addField('comment', 'text');
        $table->addField('emails', 'text');
        $table->addField('exportclassname', 'varchar(255)'); // Класс для експорта
        $table->addField('excludefields', 'text'); // Поля, которые не учитываются в експорте
        // индексы
        $table->addIndex('pdate', 'index_pdate');

        // build product category
        $table = SQLObject_Config::Get()->addClass('XShopBuildProductCategoryTask', 'shopbuildproductcategorytask');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('pdate', 'datetime');
        // индексы
        $table->addIndex('pdate', 'index_pdate');

        $table = SQLObject_Config::Get()->addClass('XShopImportTask', 'shopimporttask');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('pdate', 'datetime');
        $table->addField('userid', 'int(11)');
        $table->addField('file', 'varchar(255)');
        $table->addField('comment', 'text');
        $table->addField('importtclassname', 'varchar(255)'); // Класс для импорта
        // индексы
        $table->addIndex('pdate', 'index_pdate');

        // таблица кэша
        $table = SQLObject_Config::Get()->addClass('XShopCache', 'shopcache');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('edate', 'datetime');
        $table->addField('key', 'varchar(255)');
        $table->addField('data', 'longtext');
        // index
        $table->addIndexUnique('key', 'index_key');
        $table->addIndex('edate', 'index_edate');

        // таблица редиректов
        $table = SQLObject_Config::Get()->addClass('XShopRedirect', 'shopredirect');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('urlfrom', 'varchar(255)');
        $table->addField('urlto', 'varchar(255)');
        $table->addField('code', 'int(11)');
        // индексы
        $table->addIndexUnique('urlfrom', 'index_urlfrom');
        $table->addIndex('urlto', 'index_urlto');

        $table = SQLObject_Config::Get()->addClass('XShopSystemNotice', 'shopsystemnotice');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('linkkey', 'varchar(255)');
        $table->addField('data', 'text');
        // индексы
        $table->addIndex('linkkey', 'index_linkkey');

        // таблица SEO
        $table = SQLObject_Config::Get()->addClass('XShopSEO', 'shopseo');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('url', 'varchar(255)');  // URL
        $table->addField('seotitle', 'varchar(255)'); // seo title
        $table->addField('seoh1', 'varchar(255)'); // seo h1 header
        $table->addField('seokeywords', 'varchar(255)'); // seo meta keywords
        $table->addField('seodescription', 'varchar(255)'); // seo meta description
        $table->addField('seocontent', 'text'); // seo текст
        // индексы
        $table->addIndexUnique('url', 'index_url');

        // Значки товаров
        $table = SQLObject_Config::Get()->addClass('XShopProductIcon', 'shopproducticon');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('image', 'varchar(255)');
        $table->addField('url', 'varchar(255)');
        // indexes
        $table->addIndex('name', 'index_name');

        // page open history
        $table = SQLObject_Config::Get()->addClass('XShopHistory', 'shophistory');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('userid', 'int(11)');
        $table->addField('cdate', 'datetime');
        $table->addField('url', 'varchar(255)');
        $table->addField('ip', 'varchar(16)');
        $table->addField('post', 'text');
        // indexes
        $table->addIndex('userid', 'index_userid');
        $table->addIndex('cdate', 'index_cdate');
        $table->addIndex('url', 'index_url');

        // временная таблица shophistoryhour - в которую пишутся данные, а потом раз в час переносятся в
        // основную shophistory. Сделано исключительно ради производительности.
        // shophistoryhour специально без индексов
        $table = SQLObject_Config::Get()->addClass('XShopHistoryHour', 'shophistoryhour');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('userid', 'int(11)');
        $table->addField('cdate', 'datetime');
        $table->addField('url', 'varchar(255)');
        $table->addField('ip', 'varchar(16)');
        $table->addField('post', 'text');

        // дополнительные поля
        $table = SQLObject_Config::Get()->addClass('XShopCustomField', 'shopcustomfield');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('objecttype', 'varchar(255)');
        $table->addField('objectid', 'int(11)');
        $table->addField('key', 'varchar(255)');
        $table->addField('value', 'text');

        $table->addIndex('objectid', 'index_objectid');
        $table->addIndex('key', 'index_key');

        // astrisk ami who online
        $table = SQLObject_Config::Get()->addClass('XShopUserVoIPActive', 'shopuservoipactive2');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('number', 'varchar(32)');
        $table->addField('contactid', 'int(11)');
        // index
        $table->addIndex('number', 'index_number');

        // asterisk ami dynamic records
        $table = SQLObject_Config::Get()->addClass('XShopUserVoIP', 'shopuservoip');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('from', 'varchar(32)');
        $table->addField('to', 'varchar(32)');
        $table->addField('cdate', 'datetime');
        $table->addField('udate', 'datetime');
        $table->addField('status', 'varchar(32)');
        $table->addField('channel', 'varchar(32)');
        $table->addField('line', 'varchar(32)');
        $table->addField('duration', 'varchar(10)');
        $table->addField('closed', 'tinyint(1)');
        $table->addField('comment', 'text');
        $table->addField('contactfromid', 'int(11)');
        $table->addField('contacttoid', 'int(11)');
        // индексы
        $table->addIndex(array('to'), 'index_to');
        $table->addIndex(array('from'), 'index_from');
        $table->addIndex('contactfromid', 'index_fromid');
        $table->addIndex('contacttoid', 'index_toid');
        $table->addIndex('closed', 'index_closed');

        $table = SQLObject_Config::Get()->addClass('XShopUserLink', 'shopuserlink');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('user1id', 'int(11)');
        $table->addField('user2id', 'int(11)');
        $table->addField('comment', 'text');
        // indexes
        $table->addIndexUnique(array('user1id', 'user2id'), 'index_link');

        // отложенная очередь процессоров
        $table = SQLObject_Config::Get()->addClass('XShopProcessorQue', 'shopprocessorque');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('logicclass', 'varchar(255)');
        // индексы
        $table->addIndex('logicclass', 'index_processor');

        // для парсера почты модуля box
        $table = SQLObject_Config::Get()->addClass('XShopEventIMAPConfig', 'shopeventimapconfig');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('email', 'varchar(255)');
        $table->addField('host', 'varchar(255)');
        $table->addField('port', 'int(11)');
        $table->addField('username', 'varchar(255)');
        $table->addField('password', 'varchar(255)');
        // индексы
        $table->addIndex('email', 'email');
        $table->addIndex('host', 'host');
    }

}