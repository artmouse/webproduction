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
 * *
 *
 * @author    i.ustimenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Shop_Sync implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        /**
        * Синхронизация дефолтных значений в базу данных
        */
        try {
            SQLObject::TransactionStart(false, true);

            // всем текущим settings ставим tabname='', чтобы скрыть их
            $settings = new XShopSettings();
            while ($x = $settings->getNext()) {
                $x->setTabname('');
                $x->update();
            }

            // синхронизируем данные в таблице settings
            $sync = new SQLObjectSync_Data(new XShopSettings());

            // --- контакты ---

            $sync->addData(
                array(
                    'key' => 'header-phone',
                ),
                array(
                    'value' => '(067) 842-32-21, (050) 447-95-30, (044) 383-07-78',
                ),
                array(
                    'name' => 'Телефоны',
                    'type' => 'string',
                    'tabname' => 'Контакты',
                    'description' => 'Контактные телефоны, которые оборажаются на сайте'
                )
            );

            $sync->addData(
                array(
                    'key' => 'header-icq',
                ),
                array(
                    'value' => '626-191-284',
                ),
                array(
                    'name' => 'ICQ',
                    'type' => 'string',
                    'tabname' => 'Контакты',
                    'description' => 'ICQ, которые оборажаются на сайте'
                )
            );

            $sync->addData(
                array(
                    'key' => 'header-skype',
                ),
                array(
                    'value' => 'webproduction_sales',
                ),
                array(
                    'name' => 'skype',
                    'type' => 'string',
                    'tabname' => 'Контакты',
                    'description' => 'Skype, которые оборажаются на сайте'
                )
            );

            $sync->addData(
                array(
                    'key' => 'company-address',
                ),
                array(
                    'value' => '14000, Украина, Чернигов, пр. Победы, 129',
                ),
                array(
                    'name' => 'Адрес компании',
                    'type' => 'string',
                    'tabname' => 'Контакты',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'shop-company',
                ),
                array(
                    'value' => 'WebProduction',
                ),
                array(
                    'name' => 'Название компании',
                    'type' => 'string',
                    'tabname' => 'Контакты',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'header-email',
                ),
                array(
                    'value' => 'sales@webproduction.ua',
                ),
                array(
                    'name' => 'Email',
                    'type' => 'string',
                    'tabname' => 'Контакты',
                    'description' => 'Контактный email, который отображается на сайте'
                )
            );

            $sync->addData(
                array(
                    'key' => 'work-time',
                ),
                array(
                    'value' => 'Пн-Пт: 10.00-18.00',
                ),
                array(
                    'name' => 'Время работы',
                    'type' => 'string',
                    'tabname' => 'Контакты',
                    'description' => 'Время работы, которое отображается на сайте'
                )
            );

            $sync->addData(
                array(
                    'key' => 'header-phone-shuffle',
                ),
                array(
                    'value' => '1',
                ),
                array(
                    'name' => 'Сортировать телефоны при обновлении страницы',
                    'type' => 'boolean',
                    'tabname' => 'Контакты',
                    'description' => ''
                )
            );

            // --- уведомления: email ---


            $sync->addData(
                array(
                    'key' => 'feed-back-email',
                ),
                array(
                    'value' => 'temp@webproduction.ua',
                ),
                array(
                    'name' => 'Email для функции Написать письмо',
                    'type' => 'string',
                    'tabname' => 'Уведомления: email',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'faq-email',
                ),
                array(
                    'value' => 'temp@webproduction.ua',
                ),
                array(
                    'name' => 'Email для функции Вопрос-ответ',
                    'type' => 'string',
                    'tabname' => 'Уведомления: email',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'call-back-email',
                ),
                array(
                    'value' => 'temp@webproduction.ua',
                ),
                array(
                    'name' => 'Email для функции Обратный звонок',
                    'type' => 'string',
                    'tabname' => 'Уведомления: email',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'email-guestbook',
                ),
                array(
                    'value' => 'temp@webproduction.ua',
                ),
                array(
                    'name' => 'Email для новых отзывов о магазине',
                    'type' => 'string',
                    'tabname' => 'Уведомления: email',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'reverse-email',
                ),
                array(
                    'value' => 'no-reply@webproduction.ua',
                ),
                array(
                    'name' => 'Обратный адрес Email для писем',
                    'type' => 'string',
                    'tabname' => 'Уведомления: email',
                    'description' => 'Адрес с какого будет отправлятся письма пользователям'
                )
            );

            $sync->addData(
                array(
                    'key' => 'email-orders',
                ),
                array(
                    'value' => 'temp@webproduction.ua',
                ),
                array(
                    'name' => 'Email для уведомления о новых заказах',
                    'type' => 'html',
                    'tabname' => 'Уведомления: email',
                    'description' => 'Укажите на какие email будут приходить
                    информация о новых заказах. Укажите свои email, каждый в новой строке.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'email-tehnical',
                ),
                array(
                    'value' => 'temp@webproduction.ua',
                ),
                array(
                    'name' => 'Email для технических уведомлений',
                    'type' => 'html',
                    'tabname' => 'Уведомления: email',
                    'description' => 'Укажите на какие email будут приходить технические
                    сообщения (например, обмен данными с XLS). Укажите свои email, каждый в новой строке.'
                )
            );
            
            // --- уведомления: шаблоны писем ---
            $sync->addData(
                array(
                    'key' => 'letter-template',
                ),
                array(
                    'value' => '/templates/default/mail/index.html',
                ),
                array(
                    'name' => 'Обертка для писем',
                    'type' => 'string',
                    'tabname' => 'Уведомления: шаблоны',
                    'description' => 'Путь к шаблону-обертке письма, например (/templates/default/mail/index.html)'
                )
            );

            $sync->addData(
                array(
                    'key' => 'letter-add-callback',
                ),
                array(
                    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/add-callback.html'),
                ),
                array(
                    'name' => 'Шаблон письма "Заказной звонок"',
                    'type' => 'html',
                    'tabname' => 'Уведомления: шаблоны',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'letter-auto-feedback',
                ),
                array(
                    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/auto-feedback.html'),
                ),
                array(
                    'name' => 'Шаблон письма "Оставьте отзыв"',
                    'type' => 'html',
                    'tabname' => 'Уведомления: шаблоны',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'letter-signature',
                ),
                array(
                    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/signature.html'),
                ),
                array(
                    'name' => 'Шаблон подписи письма',
                    'type' => 'html',
                    'tabname' => 'Уведомления: шаблоны',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'letter-add-feedback',
                ),
                array(
                    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/add-feedback.html'),
                ),
                array(
                    'name' => 'Шаблон письма "Обратная связь"',
                    'type' => 'html',
                    'tabname' => 'Уведомления: шаблоны',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'letter-products-notice-of-availability',
                ),
                array(
                    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/products-notice-of-availability.html'),
                ),
                array(
                    'name' => 'Шаблон письма "Товар уже в наличии"',
                    'type' => 'html',
                    'tabname' => 'Уведомления: шаблоны',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'letter-registration',
                ),
                array(
                    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/registration.html'),
                ),
                array(
                    'name' => 'Шаблон письма "Регистрация"',
                    'type' => 'html',
                    'tabname' => 'Уведомления: шаблоны',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'letter-remindpassword',
                ),
                array(
                    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/remindpassword.html'),
                ),
                array(
                    'name' => 'Шаблон письма "Восстановление пароля"',
                    'type' => 'html',
                    'tabname' => 'Уведомления: шаблоны',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'letter-shop-faq-question',
                ),
                array(
                    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/shop-faq-question.html'),
                ),
                array(
                    'name' => 'Шаблон письма "Новый вопрос в раздел FAQ"',
                    'type' => 'html',
                    'tabname' => 'Уведомления: шаблоны',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'letter-shop-faq-answer',
                ),
                array(
                    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/shop-faq-answer.html'),
                ),
                array(
                    'name' => 'Шаблон письма "Ответ на ваш вопрос в раздел FAQ"',
                    'type' => 'html',
                    'tabname' => 'Уведомления: шаблоны',
                    'description' => ''
                )
            );


            $sync->addData(
                array(
                    'key' => 'letter-shop-guestbook-answer',
                ),
                array(
                    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/shop-guestbook-answer.html'),
                ),
                array(
                    'name' => 'Шаблон письма "Ваш отзыв был опубликован в разделе Отзывы о магазине"',
                    'type' => 'html',
                    'tabname' => 'Уведомления: шаблоны',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'letter-shop-guestbook-response',
                ),
                array(
                    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/shop-guestbook-response.html'),
                ),
                array(
                    'name' => 'Шаблон письма "Новый отзыв в разделе Отзывы о магазине"',
                    'type' => 'html',
                    'tabname' => 'Уведомления: шаблоны',
                    'description' => ''
                )
            );
            
            $sync->addData(
                array(
                    'key' => 'letter-shop-happy-birthday',
                ),
                array(
                    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/birthday.html'),
                ),
                array(
                    'name' => 'Шаблон письма "Поздравления с днем рождения"',
                    'type' => 'html',
                    'tabname' => 'Уведомления: шаблоны',
                    'description' => ''
                )
            );
            
            // --- интеграции ---

            $sync->addData(
                array(
                    'key' => 'social-button',
                ),
                array(
                    'value' => '1',
                ),
                array(
                    'name' => 'Отображать кнопки для социальных сетей',
                    'type' => 'boolean',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Показывать кнопки социальных сетей
                    (Вконтакте, Однакласники, Facebook, ...) на странице товара'
                )
            );

            $sync->addData(
                array(
                    'key' => 'use-code-1c',
                ),
                array(
                    'value' => '0',
                ),
                array(
                    'name' => 'Использовать на сайте коды 1С',
                    'type' => 'boolean',
                    'tabname' => 'Интеграции: 1С',
                    'description' => 'Вместо обычныйх ID товаров будут показаны коды 1С'
                )
            );

            $sync->addData(
                array(
                    'key' => 'use-articul',
                ),
                array(
                    'value' => '0',
                ),
                array(
                    'name' => 'Использовать на сайте артикулы',
                    'type' => 'boolean',
                    'tabname' => 'Артикул',
                    'description' => 'Вместо обычныйх кодов товаров будут артикулы'
                )
            );


            $sync->addData(
                array(
                    'key' => 'interkassa-shopid',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'InterKassa.com: ik_shop_id',
                    'type' => 'string',
                    'tabname' => 'Интеграции: InterKassa.com',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'interkassa-secretkey',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'InterKassa.com: secret key',
                    'type' => 'string',
                    'tabname' => 'Интеграции: InterKassa.com',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'integration-cloudim',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'CloudIM: код интеграции',
                    'type' => 'html',
                    'tabname' => 'Интеграции: CloudIM',
                    'description' => 'Позволяет добавить on-line чат системы CloudIM'
                )
            );

            $sync->addData(
                array(
                    'key' => 'loginza-verification',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Loginza.ru: код верификации',
                    'type' => 'html',
                    'tabname' => 'Интеграции: Loginza.ru',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'loginza-widgetid',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Loginza.ru: widget ID',
                    'type' => 'string',
                    'tabname' => 'Интеграции: Loginza.ru',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'loginza-secretkey',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Loginza.ru: secret key',
                    'type' => 'string',
                    'tabname' => 'Интеграции: Loginza.ru',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'loginza-services',
                ),
                array(
                    'value' => 'google,yandex,vkontakte,facebook,twitter',
                ),
                array(
                    'name' => 'Loginza.ru: список опций входа',
                    'type' => 'string',
                    'tabname' => 'Интеграции: Loginza.ru',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'integration-googleanalytics',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Код интеграции с Google Analytics',
                    'type' => 'html',
                    'tabname' => 'Интеграции: Google',
                    'description' => 'Позволяет добавить код сервиса Google Analytics'
                )
            );

            $sync->addData(
                array(
                    'key' => 'integration-google-wmt',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Meta-тег для подтверждения прав на Google WebMaster Tools',
                    'type' => 'html',
                    'tabname' => 'Интеграции: Google',
                    'description' => 'Позволяет добавить код для подверждения правообладаниея'
                )
            );
            
            $sync->addData(
                array(
                    'key' => 'integration-google-adwords',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Тег ремаркетинга Google Adwords',
                    'type' => 'html',
                    'tabname' => 'Интеграции: Google',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'integration-google-conversion',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Код отслеживания конверсии Google',
                    'type' => 'html',
                    'tabname' => 'Интеграции: Google',
                    'description' => 'Добавляется на странице /basket/success/'
                )
            );

            $sync->addData(
                array(
                    'key' => 'integration-google-adsence-left',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Код рекламного блока Google AdSence',
                    'type' => 'html',
                    'tabname' => 'Интеграции: Google',
                    'description' => 'Добавляет рекламный баннер в левой колонке'
                )
            );

            $sync->addData(
                array(
                    'key' => 'integration-google-adsence-right',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Код рекламного блока Google AdSence',
                    'type' => 'html',
                    'tabname' => 'Интеграции: Google',
                    'description' => 'Добавляет рекламный баннер в правой колонке'
                )
            );

            $sync->addData(
                array(
                    'key' => 'integration-yandex-wmt',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Meta-тег для подтверждения прав на Yandex WebMaster Tools',
                    'type' => 'html',
                    'tabname' => 'Интеграции: Yandex',
                    'description' => 'Позволяет добавить код для подверждения правообладания'
                )
            );

            $sync->addData(
                array(
                    'key' => 'integration-yandex-metrika-token',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Яндекс.Метрика auth token',
                    'type' => 'string',
                    'tabname' => 'Интеграции: Yandex',
                    'description' => 'Для построения отчетов Воронка продаж и т.д.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'integration-yandex-metrika-counterid',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Яндекс.Метрика counter ID',
                    'type' => 'string',
                    'tabname' => 'Интеграции: Yandex',
                    'description' => 'Для построения отчетов Воронка продаж и т.д.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'integration-liveinternet',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Код интеграции с LiveInternet',
                    'type' => 'html',
                    'tabname' => 'Интеграции: LiveInternet',
                    'description' => 'Позволяет добавить код сервиса LiveInternet'
                )
            );

            $sync->addData(
                array(
                    'key' => 'integration-yandex-counter',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Интеграция с Яндекс.Счетчик',
                    'type' => 'html',
                    'tabname' => 'Интеграции: Yandex',
                    'description' => 'Счетчик посещаемости веб-сайтов, и анализа поведения пользователей.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'facebook-widget',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Facebook Social Widget',
                    'type' => 'html',
                    'tabname' => 'Интеграции: Facebook',
                    'description' => 'Позволяет добавить виджет facebook.com'
                )
            );

            $sync->addData(
                array(
                    'key' => 'integration-facebook-pixel-head',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Facebook Pixel',
                    'type' => 'html',
                    'tabname' => 'Интеграции: Facebook',
                    'description' => 'Позволяет добавить код сервиса Facebook Pixel в head'
                )
            );

            $sync->addData(
                array(
                    'key' => 'integration-facebook-pixel-body',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Facebook Pixel',
                    'type' => 'html',
                    'tabname' => 'Интеграции: Facebook',
                    'description' => 'Позволяет добавить код сервиса Facebook Pixel в body'
                )
            );

            $sync->addData(
                array(
                    'key' => 'integration-comments',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Интеграция с системой комментариев',
                    'type' => 'html',
                    'tabname' => 'Интеграции: Система комментариев',
                    'description' => 'Вставьте сюда код виджета комментариев facebook,
                    vk.com, disqus или другой. Форма комментирования появиться в каждом товаре.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'integration-disqus-news',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Форма комментирования для статей/новостей/страниц',
                    'type' => 'html',
                    'tabname' => 'Интеграции: Система комментариев',
                    'description' => 'Вставьте сюда код виджета комментариев disqus.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'product-export-xml-json',
                ),
                array(
                    'value' => '0',
                ),
                array(
                    'name' => 'Выгружать продукты в XML + JSON',
                    'type' => 'boolean',
                    'tabname' => 'Интеграции: Учетные системы',
                    'description' => 'Каждый час продукты будут выгружатся в файл формата XML и JSON.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'brand-export-xml-json',
                ),
                array(
                    'value' => '0',
                ),
                array(
                    'name' => 'Выгружать бренды в XML + JSON',
                    'type' => 'boolean',
                    'tabname' => 'Интеграции: Учетные системы',
                    'description' => 'Каждый час бренды будут выгружатся в файл формата XML и JSON.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'category-export-xml-json',
                ),
                array(
                    'value' => '0',
                ),
                array(
                    'name' => 'Выгружать категории в XML + JSON',
                    'type' => 'boolean',
                    'tabname' => 'Интеграции: Учетные системы',
                    'description' => 'Каждый час категории будут выгружатся в файл формата XML и JSON.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'sms-login',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Интеграция с SMS: API login',
                    'type' => 'string',
                    'tabname' => 'Интеграции SMS',
                    'description' => 'Поле для логина сервиса SMS'
                )
            );

            $sync->addData(
                array(
                    'key' => 'sms-password',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Интеграция с SMS: API password',
                    'type' => 'string',
                    'tabname' => 'Интеграции SMS',
                    'description' => 'Поле для пароля сервиса SMS'
                )
            );

            $sync->addData(
                array(
                    'key' => 'sms-sender',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Интеграция с SMS: отправитель (подпись)',
                    'type' => 'string',
                    'tabname' => 'Интеграции SMS',
                    'description' => 'Позволяет настроить подпись сообщений отправляемых с помощью SMS'
                )
            );

            $sync->addData(
                array(
                    'key' => 'sms-admin-phone',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Интеграция с SMS: Номер телефона администратора',
                    'type' => 'string',
                    'tabname' => 'Интеграции SMS',
                    'description' => 'Если вы заполните это поле, то сообщения о
                    заказах будут приходить на этот номер телефона. Формат номера телефона: 380ХХХХХХХХХ'
                )
            );

            $sync->addData(
                array(
                    'key' => 'sms-service-sms-send',
                ),
                array(
                    'value' => 'TurboSMS',
                ),
                array(
                    'name' => 'Какой сервис использовать для отправки SMS',
                    'type' => 'select-smstype',
                    'tabname' => 'Интеграции SMS'
                )
            );

            // Платежная система (LiqPay)
            $sync->addData(
                array(
                    'key' => 'public-key',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'LiqPay: public key',
                    'type' => 'string',
                    'tabname' => 'Интеграции: LiqPay',
                    'description' => 'Позволяет настроить платежную систему, для оплаты заказа. '
                )
            );

            $sync->addData(
                array(
                    'key' => 'private-key',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'LiqPay: private key',
                    'type' => 'string',
                    'tabname' => 'Интеграции: LiqPay',
                    'description' => 'Позволяет настроить платежную систему, для оплаты заказа. '
                )
            );

            // --- интеграция с 1С ---

            $sync->addData(
                array(
                    'key' => 'ftp-hostname',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Синхронизация с 1C: FTP-hostname',
                    'type' => 'string',
                    'tabname' => 'Интеграции: 1С',
                    'description' => 'Поле для имени FTP-сервера'
                )
            );

            $sync->addData(
                array(
                    'key' => 'ftp-port',
                ),
                array(
                    'value' => '21',
                ),
                array(
                    'name' => 'Синхронизация с 1C: FTP-port',
                    'type' => 'string',
                    'tabname' => 'Интеграции: 1С',
                    'description' => 'Поле для порта к FTP-серверу'
                )
            );

            $sync->addData(
                array(
                    'key' => 'ftp-login',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Синхронизация с 1C: FTP-login',
                    'type' => 'string',
                    'tabname' => 'Интеграции: 1С',
                    'description' => 'Поле логина для FTP-соединения'
                )
            );

            $sync->addData(
                array(
                    'key' => 'ftp-password',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Синхронизация с 1C: FTP-password',
                    'type' => 'string',
                    'tabname' => 'Интеграции: 1С',
                    'description' => 'Поле пароля для FTP-соединения'
                )
            );

            // --- встроенные модуля и функции ---

            $sync->addData(
                array(
                    'key' => 'found-cheaper',
                ),
                array(
                    'value' => '1',
                ),
                array(
                    'name' => 'Показывать блок "Нашли дешевле"',
                    'type' => 'boolean',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Если Вы согласны уступить цену клиенту,
                    при условие, что на другом сайте такой же товар продается дешевле, поставте галочку.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'show-filters',
                ),
                array(
                    'value' => '1',
                ),
                array(
                    'name' => 'Показывать блок "Блок фильтров"',
                    'type' => 'boolean',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Если вы хотите дать возможность клиентам,
                    пользоваться фильтрами по параметрам в спике товаров, включите данную опцию.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'products-notice-of-availability',
                ),
                array(
                    'value' => '1',
                ),
                array(
                    'name' => 'Показывать блок "Сообщите когда появится"',
                    'type' => 'boolean',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Ежедневно товары обновляются, и если товар
                    появился в наличии уведомить об этом клиента, путем отправки соответсвующего уведомления на email'
                )
            );

            $sync->addData(
                array(
                    'key' => 'shop-auth-for-order',
                ),
                array(
                    'value' => '0',
                ),
                array(
                    'name' => 'Требуется ли авторизация для оформления заказа',
                    'type' => 'boolean',
                    'tabname' => 'Оформление заказов',
                    'description' => 'Данная опция позовляет включить/выключить
                    режим продажи товара незарегестрированным пользователям'
                )
            );

            $sync->addData(
                array(
                    'key' => 'show-hide-purchase-price',
                ),
                array(
                    'value' => '0',
                ),
                array(
                    'name' => 'Показывать поставщика и закупочные цены при оформлении заказа',
                    'type' => 'boolean',
                    'tabname' => 'Оформление заказов',
                    'description' => 'Данная опция даст возможность скрыть или показать
                    закупочную цену товара и его поставщики при оформлении заказа'
                )
            );

            $sync->addData(
                array(
                    'key' => 'shop-email-required-for-order',
                ),
                array(
                    'value' => '0',
                ),
                array(
                   'name' => 'Обязательный ввод email для оформления заказа',
                   'type' => 'boolean',
                   'tabname' => 'Оформление заказов',
                   'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'response',
                ),
                array(
                    'value' => 1,
                ),
                array(
                    'name' => 'Отоброжать блок с последними отзывами из раздела "Отзывы о магазине"',
                    'type' => 'boolean',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Настройка отображения блока "Отзывы о нас" на сайте'
                )
            );

            $sync->addData(
                array(
                    'key' => 'product-barcode-show',
                ),
                array(
                    'value' => 1,
                ),
                array(
                    'name' => 'Показывать штрих-коды на сайте',
                    'type' => 'boolean',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Включение/отключение отображения штрих-кодов на сайте'
                )
            );

            $sync->addData(
                array(
                    'key' => 'project-show-line-project',
                ),
                array(
                    'value' => 1,
                ),
                array(
                    'name' => 'Отображать поле проект для проектов',
                    'type' => 'boolean',
                    'tabname' => 'Внешний вид в админ-панели',
                    'description' => 'Отображать поле проект для проектов, при редактировании проектов в админ-панели'
                )
            );

            $sync->addData(
                array(
                    'key' => 'company-info-in-user-card',
                ),
                array(
                    'value' => 1,
                ),
                array(
                    'name' => 'Отображать информацию о компании в карточке контакта',
                    'type' => 'boolean',
                    'tabname' => 'Внешний вид в админ-панели',
                    'description' => ''
                )
            );



            $sync->addData(
                array(
                    'key' => 'product-downloadfile-ttl',
                ),
                array(
                    'value' => 1440,
                ),
                array(
                    'name' => 'Скачиваемые товары: время жизни ссылки',
                    'type' => 'string',
                    'tabname' => 'Оформление заказов',
                    'description' => 'Укажите время жизни ссылки (в минутах)'
                )
            );

            $sync->addData(
                array(
                    'key' => 'response-maxcount',
                ),
                array(
                    'value' => 3,
                ),
                array(
                    'name' => 'Блок отзывов: максимальное количество отоброжаемых отзывов',
                    'type' => 'string',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Позволяет настроить количество выводимых записей в блок "Отзывы о нас"'
                )
            );

            $sync->addData(
                array(
                    'key' => 'shop-onpage',
                ),
                array(
                    'value' => '12',
                ),
                array(
                    'name' => 'Количество товаров на странице',
                    'type' => 'string',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => ''
                )
            );

            // --- водяной знак ---

            $sync->addData(
                array(
                    'key' => 'watermark-image',
                ),
                array(
                    'value' => ''
                ),
                array(
                    'name' => 'Водяной знак: изображение',
                    'type' => 'image',
                    'tabname' => 'Водяные знаки',
                    'description' => 'Принимается только формат PNG'
                )
            );

            $sync->addData(
                array(
                    'key' => 'watermark-position-x',
                ),
                array(
                    'value' => 'center',
                ),
                array(
                    'name' => 'Водяной знак: позиция по ширине',
                    'type' => 'string',
                    'tabname' => 'Водяные знаки',
                    'description' => 'Как накладывать водяной знак на картинку по ширине.
                    Можно указать значения left, right или center. После изменения не забудьте сбросить кеш.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'watermark-position-y',
                ),
                array(
                    'value' => 'center',
                ),
                array(
                    'name' => 'Водяной знак: позиция по высоте',
                    'type' => 'string',
                    'tabname' => 'Водяные знаки',
                    'description' => 'Как накладывать водяной знак на картинку по высоте.
                    Можно указать значения top, bottom или center. После изменения не забудьте сбросить кеш.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'watermark-proportion-size',
                ),
                array(
                    'value' => '4',
                ),
                array(
                    'name' => 'Водяной знак: относительный размер',
                    'type' => 'string',
                    'tabname' => 'Водяные знаки',
                    'description' => 'Отношения размера изображения к размеру вотермарки.'
                )
            );

            // Текста

            $sync->addData(
                array(
                    'key' => 'characteristics-message',
                ),
                array(
                    'value' => 'Характеристики и комплектация товара могут изменяться производителем без уведомления.',
                ),
                array(
                    'name' => 'Информация об измении комплектации',
                    'type' => 'html',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Данный текст будет отображается в нижней части карточки товара.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'used-user-info',
                ),
                array(
                    'value' => 'Хранение и использование компанией «WebProduction» предоставленных
                    пользователями личных данных полностью соответствует действующему законодательству
                    Украины о неприкосновенности личной информации. Личные данные пользователей не
                    предоставляются третьим лицам, но сохраняются для предоставления услуги продажи товаров,
                    представленных на нашем сайте. Компания оставляет за собой право
                    использовать данную информацию в маркетинговых целях.',
                ),
                array(
                    'name' => 'Соглашение о предоставлении личных данных',
                    'type' => 'html',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Информация, которую клиент видет при регистрации,
                    редактировании своего профиля и офрмлении заказа'
                )
            );

            $sync->addData(
                array(
                    'key' => 'order-good-message',
                ),
                array(
                    'value' => 'Спасибо за ваш заказ! В ближайшее время с вами свяжется наш менеджер.',
                ),
                array(
                    'name' => 'Сообщение после удачного оформления заказа',
                    'type' => 'html',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'После удачного оформления заказа будет выводится это сообщение'
                )
            );

            $sync->addData(
                array(
                    'key' => 'registration-good-message',
                ),
                array(
                    'value' => 'Вы успешно зарегистрированы и вошли.',
                ),
                array(
                    'name' => 'Сообщение после удачной регистрации пользователя',
                    'type' => 'html',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'После удачной регистрации будет выводится это сообщение'
                )
            );

            $sync->addData(
                array(
                    'key' => 'logout-good-message',
                ),
                array(
                    'value' => 'Вы успешно вышли из системы.',
                ),
                array(
                    'name' => 'Сообщение после удачного выхода из системы',
                    'type' => 'html',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'После выхода из системы будет выводиться это сообщение'
                )
            );

            $sync->addData(
                array(
                    'key' => 'warranty',
                ),
                array(
                    'value' => '<ul>
                    <li>12 месяцев официальной гарантии от производителя.</li>
                    <li>обмен/возврат товара в течение 14 дней</li>
                    </ul>',
                ),
                array(
                    'name' => 'Гарантии на товар',
                    'type' => 'html',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Позволяет добавить сообщение о гарантии по умолчанию'
                )
            );

            $sync->addData(
                array(
                    'key' => 'payment',
                ),
                array(
                    'value' => '<ul>
                    <li>товара может производится по факту получения</li>
                    </ul>',
                ),
                array(
                    'name' => 'Оплата товара',
                    'type' => 'html',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Позволяет добавить сообщение об оплате товара по умолчанию'
                )
            );

            $sync->addData(
                array(
                    'key' => 'delivery',
                ),
                array(
                    'value' => '<ul>
                    <li>по городу: БЕСПЛАТНО!</li>
                    <li>оплата при получении товара</li>
                    </ul>',
                ),
                array(
                    'name' => 'Доставка товара',
                    'type' => 'html',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Позволяет добавить сообщение о доставке по умолчанию'
                )
            );

            $sync->addData(
                array(
                    'key' => 'seo-text-in-index-page',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Текст на главную',
                    'type' => 'text',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'SEO-текст вверху страницы'
                )
            );

            $sync->addData(
                array(
                    'key' => 'copyright',
                ),
                array(
                    'value' => 'Copyright &copy; 2010-'.date('Y').
                        ' <a href="http://webproduction.ua/" target="_blank">WebProduction&trade;</a>',
                ),
                array(
                    'name' => 'Copyright',
                    'type' => 'html',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => ''
                )
            );

            // --- Настройки магазина ---

            $sync->addData(
                array(
                    'key' => 'send-auto-feedback',
                ),
                array(
                    'value' => 0,
                ),
                array(
                    'name' => 'Отправлять email клиенту, через 3 недели с просьбой, оставить комментарий',
                    'type' => 'boolean',
                    'tabname' => 'Оформление заказов',
                    'description' => 'Включить автоматическую отправку писем, с просьбой оставить комментарий'
                )
            );

            $sync->addData(
                array(
                    'key' => 'phone-mask',
                ),
                array(
                    'value' => '+38 (099) 999-99-99',
                ),
                array(
                    'name' => 'Маска (формат) для номеров телефонов',
                    'type' => 'string',
                    'tabname' => 'Оформление заказов',
                    'description' => 'Примеры масок: Украина +38 (099) 999-99-99,
                    Казахстан +7 (799) 999-99-99, Беларусь +375 (99) 999-99-99'
                )
            );

            $sync->addData(
                array(
                    'key' => 'phone-doublicates',
                ),
                array(
                    'value' => 0,
                ),
                array(
                    'name' => 'Разрешить дубликаты телефона',
                    'type' => 'boolean',
                    'tabname' => 'Оформление заказов',
                    'description' => 'Разрешить создание контактов с одинаковыми телефонами'
                )
            );

            $sync->addData(
                array(
                    'key' => 'product-name-doublicates',
                ),
                array(
                    'value' => 1,
                ),
                array(
                    'name' => 'Разрешить дубликаты товаров',
                    'type' => 'boolean',
                    'tabname' => 'Оформление заказов',
                    'description' => 'Разрешить создание товаров с одинаковыми именами'
                )
            );

            $sync->addData(
                array(
                    'key' => 'show-menu-brands',
                ),
                array(
                    'value' => 1,
                ),
                array(
                    'name' => 'Показывать бренды в меню',
                    'type' => 'boolean',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Включение/отключение  отображения кнопки Бренды в меню'
                )
            );

            $sync->addData(
                array(
                    'key' => 'show-header-phone',
                ),
                array(
                    'value' => 1,
                ),
                array(
                    'name' => 'Показывать телефоны в шапке сайта',
                    'type' => 'boolean',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Включение/отключение  отображения телефонов в шапке сайта'
                )
            );

            $sync->addData(
                array(
                    'key' => 'show-header-icq',
                ),
                array(
                    'value' => 0,
                ),
                array(
                    'name' => 'Показывать ICQ в шапке сайта',
                    'type' => 'boolean',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Включение/отключение  отображения ICQ в шапке сайта'
                )
            );

            $sync->addData(
                array(
                    'key' => 'show-header-email',
                ),
                array(
                    'value' => 0,
                ),
                array(
                    'name' => 'Показывать email в шапке сайта',
                    'type' => 'boolean',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Включение/отключение  отображения email в шапке сайта'
                )
            );

            $sync->addData(
                array(
                    'key' => 'show-header-address',
                ),
                array(
                    'value' => 0,
                ),
                array(
                    'name' => 'Показывать адрес в шапке сайта',
                    'type' => 'boolean',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Включение/отключение  отображения адреса в шапке сайта'
                )
            );

            $sync->addData(
                array(
                    'key' => 'show-header-skype',
                ),
                array(
                    'value' => 0,
                ),
                array(
                    'name' => 'Показывать Skype в шапке сайта',
                    'type' => 'boolean',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Включение/отключение  отображения Skype в шапке сайта'
                )
            );

            $sync->addData(
                array(
                    'key' => 'unregistered-users-to-post-reviews',
                ),
                array(
                    'value' => 1,
                ),
                array(
                    'name' => 'Разрешить добавление отзывов незарегистрированными пользователями',
                    'type' => 'boolean',
                    'tabname' => 'Оформление заказов',
                    'description' => 'Разрешить оставлять отзывы о магазине незарегистрированным пользователям'
                )
            );

            $sync->addData(
                array(
                    'key' => 'image-format',
                ),
                array(
                    'value' => 'jpg',
                ),
                array(
                    'name' => 'Формат хранения изображений (в том числе thumbnail-файлов)',
                    'type' => 'string',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Доступны: jpg, png. По умолчанию - jpg.
                    Некоторые картинки все равно будут в формате PNG.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'crop-enable',
                ),
                array(
                    'value' => 1,
                ),
                array(
                    'name' => 'Пропорции основного изображения: включить',
                    'type' => 'boolean',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Если включена эта опция, то основное
                    изображение будет только в определенных пропорциях'
                )
            );

            $sync->addData(
                array(
                    'key' => 'cropwidth',
                ),
                array(
                    'value' => 93,
                ),
                array(
                    'name' => 'Пропорции основного изображения: ширина',
                    'type' => 'string',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'введите пропорции соотношения ширины для основного изображения (например: 100).
                    Загружаемое изображение должно быть больше заданных пропорций.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'cropheight',
                ),
                array(
                    'value' => 70,
                ),
                array(
                    'name' => 'Пропорции основного изображения: высота',
                    'type' => 'string',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'введите пропорции соотношения высоты для основного изображения (например: 100).
                    Загружаемое изображение должно быть больше заданных пропорций.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'order-dateto-days',
                ),
                array(
                    'value' => 3,
                ),
                array(
                    'name' => 'Количество дней до выполнения заказа',
                    'type' => 'string',
                    'tabname' => 'Оформление заказов',
                    'description' => 'Позволяет настроить параметр заказа
                    "Выполнить до"(по умолчанию +3 дня к дате оформления заказа)'
                )
            );

            $sync->addData(
                array(
                    'key' => 'product-cansale-unavail',
                ),
                array(
                    'value' => 1,
                ),
                array(
                    'name' => 'Можно заказывать товар, если его нет в наличии',
                    'type' => 'boolean',
                    'tabname' => 'Оформление заказов',
                    'description' => 'Включение/отключение возможности покупки товара помеченного, как "нет в наличии"'
                )
            );

            $sync->addData(
                array(
                    'key' => 'filtering-product-on-presence',
                ),
                array(
                    'value' => 1,
                ),
                array(
                    'name' => 'Сортировать по наличию товара',
                    'type' => 'boolean',
                    'tabname' => 'Настройки магазина',
                    'description' => 'Сначала идут товары которые есть в наличии, а потом которых в наличии нет'
                )
            );

            $sync->addData(
                array(
                    'key' => 'manager-auto-author',
                ),
                array(
                    'value' => 1,
                ),
                array(
                    'name' => 'Назначать менеджером того, кто создал контакт',
                    'type' => 'boolean',
                    'tabname' => 'Настройки магазина',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'user-account-activate',
                ),
                array(
                    'value' => 1,
                ),
                array(
                    'name' => 'Активация аккаунта – подтверждение регистрации на сайте',
                    'type' => 'boolean',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Включение/отключение подтверждения регистрации через e-mail'
                )
            );

            $sync->addData(
                array(
                    'key' => 'price-rounding-off',
                ),
                array(
                    'value' => 0,
                ),
                array(
                    'name' => 'Округление цен',
                    'type' => 'boolean',
                    'tabname' => 'Пересчет цен и наличия',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'favicon',
                ),
                array(
                    'value' => '/_images/favicon.ico',
                ),
                array(
                    'name' => 'Favicon',
                    'type' => 'image',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Изображение, которое  отображается браузером в адресной строке перед URL страницы'
                )
            );

            $sync->addData(
                array(
                    'key' => 'background-image',
                ),
                array(
                    'value' => '', // /_images/bg.jpg
                ),
                array(
                    'name' => 'Фоновая картинка',
                    'type' => 'image',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Изображение, которое  отображается как фон сайта
                    (Рекомендованные размеры: ширина - 1913px, высота - 1885px)'
                )
            );

            $sync->addData(
                array(
                    'key' => 'image-404',
                ),
                array(
                    'value' => '',
                ),
                array(
                    'name' => 'Картинка 404',
                    'type' => 'image',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Изображение, которое отображается, когда не найдена страница на сайте.'
                )
            );

            $sync->addData(
                array(
                    'key' => 'topBannerHeightMax',
                ),
                array(
                    'value' => '340',
                ),
                array(
                    'name' => 'Максимальная высота баннера сверху',
                    'type' => 'string',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => 'Максимальная высота баннера, в пикселях, имеющего расположение "Сверху"'
                )
            );


            $sync->addData(
                array(
                    'key' => 'shop-name',
                ),
                array(
                    'value' => 'OneBox',
                ),
                array(
                    'name' => 'Название магазина',
                    'type' => 'string',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'shop-slogan',
                ),
                array(
                    'value' => 'OneBox',
                ),
                array(
                    'name' => 'Слоган магазина',
                    'type' => 'string',
                    'tabname' => 'Блоки, отображение, внешний вид',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'product-url-type',
                ),
                array(
                    'value' => 'name',
                ),
                array(
                    'name' => 'Поле для формирования url-ов для товаров',
                    'type' => 'string',
                    'tabname' => 'SEO',
                    'description' => 'Поле по которому будут формироватся ЧПУ для товаров.
                    Доступные значения: name, code1c'
                )
            );

            $sync->addData(
                array(
                    'key' => 'autoupdate',
                ),
                array(
                    'value' => 0,
                ),
                array(
                    'name' => 'Разрешить автообновление системы на новую версию.',
                    'type' => 'boolean',
                    'tabname' => 'Автообновление',
                    'description' => ''
                )
            );

            $sync->addData(
                array(
                    'key' => 'min-price-export-places',
                ),
                array(
                    'value' => 500,
                ),
                array(
                    'name' => 'Минимальная цена на экспорт',
                    'type' => 'string',
                    'tabname' => 'Прайс-площадки',
                    'description' => 'Товары у которых цена ниже указанной, экспортироваться не будут.'
                )
            );
            $sync->sync();

            // логотип
            $tmp = new XShopLogo();
            if (!$tmp->select()) {
                $sync = new SQLObjectSync_Data(new XShopLogo());

                $sync->addData(
                    array(
                        'name' => 'OneBox default logo'
                    ),
                    array(
                        'file' => 'logo.png',
                        'default' => 1
                    )
                );

                $sync->sync();
            }

            // бизнес-процесс
            $tmp = new XShopOrderStatus();
            if (!$tmp->select()) {
                $sync = new SQLObjectSync_Data(new XShopOrderCategory());

                $sync->addData(
                    array(
                        'name' => 'Новый Заказ'
                    ),
                    array(
                        'default' => 1,
                        'type' => 'order',
                    )
                );

                $sync->sync();
            }

            // типы бизнес-процессов
            $tmp = new XShopWorkflowType();
            if (!$tmp->select()) {
                $sync = new SQLObjectSync_Data(new XShopWorkflowType());

                $sync->addData(
                    array(
                        'name' => Shop::Get()->getTranslateService()->getTranslate('translate_proekt')
                    ),
                    array(
                        'type' => 'project',
                        'calendarShow' => 1
                    )
                );

                $sync->addData(
                    array(
                        'name' => Shop::Get()->getTranslateService()->getTranslate('translate_task')
                    ),
                    array(
                        'type' => 'issue',
                        'calendarShow' => 1
                    )
                );

                $sync->addData(
                    array(
                        'name' => Shop::Get()->getTranslateService()->getTranslate('translate_ord')
                    ),
                    array(
                        'type' => 'order',
                        'calendarShow' => 1
                    )
                );

                $sync->sync();
            }

            // статус заказов
            $tmp = new XShopOrderStatus();
            if (!$tmp->select()) {
                $sync = new SQLObjectSync_Data(new XShopOrderStatus());

                $sync->addData(
                    array(
                        'name' => 'Новый'
                    ),
                    array(
                        'categoryid' => 1,
                        'default' => 1,
                        'message' => @file_get_contents(MEDIA_PATH.'/mail-templates/shop-order-new.html'),
                        'messageadmin' => @file_get_contents(MEDIA_PATH.'/mail-templates/shop-order-new-admin.html'),
                        // 'colour' => '#F5D4C9'
                    )
                );

                $sync->sync();
            }

            // юридические лица
            $tmp = new XShopContractor();
            if (!$tmp->select()) {
                $sync = new SQLObjectSync_Data(new XShopContractor());

                $sync->addData(
                    array(
                    'name' => 'Юридическое лицо'
                    ),
                    array(
                        'active' => 1,
                        'tax' => 0,
                        'details' => ''
                    )
                );

                $sync->sync();
            }

            // доступные прайс-площадки
            $sync = new SQLObjectSync_Data(new XShopExportPlace());

            $sync->addData(
                array('logicclass' => 'Shop_ExportYML'),
                array('name' => 'Яндекс.Маркет (YML)')
            );
            $sync->addData(
                array('logicclass' => 'Shop_ExportPromUA'),
                array('name' => 'Prom.ua (YML)')
            );
            $sync->addData(
                array('logicclass' => 'Shop_ExportPriceUA'),
                array('name' => 'Price.ua')
            );
            $sync->addData(
                array('logicclass' => 'Shop_ExportNadavi'),
                array('name' => 'NADAVI')
            );
            $sync->addData(
                array('logicclass' => 'Shop_ExportHotline'),
                array('name' => 'Hotline')
            );
            $sync->addData(
                array('logicclass' => 'Shop_ExportECatalog'),
                array('name' => 'E-catalog')
            );
            $sync->addData(
                array('logicclass' => 'Shop_ExportFreemarket'),
                array('name' => 'FreeMarket')
            );

            $sync->sync();

            // синхронизация списка валют
            $tmp = new XShopCurrency();
            if (!$tmp->select()) {
                $sync = new SQLObjectSync_Data(new XShopCurrency());

                $sync->addData(
                    array('name' => 'UAH'),
                    array('symbol' => 'грн.', 'default' => 1, 'rate' => 1, 'sort' => 0)
                );
                $sync->addData(
                    array('name' => 'USD'),
                    array('symbol' => '$', 'default' => 0, 'rate' => 8.78, 'sort' => 1)
                );
                $sync->addData(
                    array('name' => 'RUB'),
                    array('symbol' => 'р.', 'default' => 0, 'rate' => 0.25, 'sort' => 2)
                );
                $sync->addData(
                    array('name' => 'EUR'),
                    array('symbol' => '€', 'default' => 0, 'rate' => 12, 'sort' => 3)
                );
                $sync->sync();
            }

            //Установление дефолтной валюты
            //@TODO нужно делать полный пересчет магазина при смнене базовой валюты
            $tmp = new XShopCurrency();
            $currencyDefaultName = Engine::Get()->getConfigFieldSecure('currency-default');
            if ($currencyDefaultName) {
                try {
                    $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();
                    if ($currencyDefaultName != $currencySystem->getName()) {
                        $currency = Shop::Get()->getCurrencyService()->getCurrencyByName($currencyDefaultName);
                        $currency->setDefault(1);
                        $currency->update();

                        $currencySystem->setDefault(0); //устанавливаем в 0 предыдущию базовую валюту
                        $currencySystem->update();

                    }

                } catch (Exeption $e) {
                    //Если нету системной валюты установим
                    try {
                        $currency = Shop::Get()->getCurrencyService()->getCurrencyByName($currencyDefaultName);
                        $currency->setDefault(1);
                        $currency->update();
                    } catch (Exeption $e) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $e;
                        }
                    }

                }
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }

        // регистрация block-ов в таблице блоков
        $blockArray = array();
        $blockArray[] = 'block-mymanager';
        $blockArray[] = 'block-productfilter';
        $blockArray[] = 'block-news';
        $blockArray[] = 'block-guestbook';
        $blockArray[] = 'block-faq';
        $blockArray[] = 'block-facebook';
        $blockArray[] = 'block-banner-top';
        $blockArray[] = 'block-banner-wide';
        $blockArray[] = 'block-banner-top-index';
        $blockArray[] = 'block-banner-left';
        $blockArray[] = 'block-banner-right';
        $blockArray[] = 'block-banner-bottom';
        $blockArray[] = 'block-timework';
        $blockArray[] = 'block-search';
        $blockArray[] = 'block-menu-category';
        $blockArray[] = 'block-menu-brand';
        $blockArray[] = 'block-menu-textpage';
        $blockArray[] = 'block-brand-top';
        $blockArray[] = 'block-category-top';
        $blockArray[] = 'block-feedback';
        $blockArray[] = 'block-callback';
        $blockArray[] = 'block-subscribe';
        $blockArray[] = 'block-compare';
        $blockArray[] = 'block-footer-category';
        $blockArray[] = 'block-footer-textpage';
        $blockArray[] = 'block-brand-alphabet';
        $blockArray[] = 'block-banner-pageinterval';

        foreach ($blockArray as $contentID) {
            $block = new XShopBlock();
            $block->setContentid($contentID);
            if (!$block->select()) {
                $block->setActive(1);
                $block->setName(str_replace('block-', '', $contentID));
                $block->insert();
            }

            $block->setSystem(1);
            $block->update();
        }

        Shop::Get()->getSettingsService()->addSetting(
            'calendar-cdate',
            'Показывать задачу в календаре в день ее старта',
            'Внешний вид в админ-панели',
            '',
            '0',
            'boolean'
        );

        Shop::Get()->getSettingsService()->addSetting(
            'user-robot',
            'Пользователь по умолчанию',
            'Настройки магазина',
            'Пользователь, от имени которого будут выполняться действия в кроне',
            '1',
            'string'
        );

        Shop::Get()->getSettingsService()->addSetting(
            'color-menu',
            'Цвет шапки меню',
            'Внешний вид в админ-панели',
            '',
            '',
            'color'
        );

        Shop::Get()->getSettingsService()->addSetting(
            'find-user-by-contact',
            'Искать пользователя по контактным данным, при создании нового пользователя',
            'Настройки магазина',
            '',
            '1',
            'boolean'
        );

        Shop::Get()->getSettingsService()->addSetting(
            'show-old-price-persent-limit',
            'Показывать старую цену если она больше новой на X%',
            'Настройки магазина',
            '',
            '0',
            'string'
        );

        Shop::Get()->getSettingsService()->addSetting(
            'verifying-name',
            'Разрешить проверку ФИО',
            'Проверка ФИО',
            'При добавление нового контакта проверять его ФИО на наличие посторонних символов',
            '1', 
            'boolean'
        );
    }

}