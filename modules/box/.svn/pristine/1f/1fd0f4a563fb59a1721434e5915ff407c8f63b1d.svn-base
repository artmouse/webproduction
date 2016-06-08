<?php

/**
 * Примеры возможностей OneBox для файла engine.mode.php
 */

// включить oneclick даже в режиме box (по умолчанию false)
Engine::Get()->setConfigField('oneclick-enable', true);

// переименовать логотип в админке OneBox
Engine::Get()->setConfigField('project-branding', 'Yazz Box');

// обработчик номеров.
// используется когда необходимо приводить номера к единому виду, и это
// проще чем править AMI
Engine::Get()->setConfigField('project-box-event-parser-call-processor', 'BoxNumberProcessor_Yazz');

class BoxNumberProcessor_Yazz {

    public function process($phone) {
        // это внутренний номер
        if (strlen($phone) <= 4) {
            return $phone;
        }

        // отрезание первых двух цифр (наиболее частая ситуация)
        if (preg_match("/\d{2}(\d{12})/ius", $phone, $r)) {
            $phone = $r[1];
        }

        return $phone;
    }

}

// обработчик линии
Engine::Get()->setConfigField('project-box-event-parser-call-line-processor', 'BoxLineProcessor_ProfiDM');

/*class BoxLineProcessor_ProfiDM {

    public function process($from, $channel) {
        if (preg_match("/^SIP\/(\d+)\-/ius", $channel, $r)) {
            if ($r[1] == '901') {
                return '77172689689';
            }
            if ($r[1] == '902') {
                return '77172689919';
            }
            if ($r[1] == '903') {
                return '77172689918';
            }
            if ($r[1] == '904') {
                return '77172755248';
            }
        }

        if (preg_match("/^01/ius", $from)) {
            return '77055849631';
        }
        if (preg_match("/^02/ius", $from)) {
            return '77019180055';
        }
        if (preg_match("/^03/ius", $from)) {
            return '77018009861';
        }
        if (preg_match("/^04/ius", $from)) {
            return '77753350518';
        }

        return '';
    }

}*/

// с каких емейлов создавать задачи в какие проекты
$a = array();
// для писем с ящика
$a['task@yazz.com.ua'] = array(
'workflowid' => 3, // бизнес-процесс для старта задачи
'managerid' => 3, // менеджер на которого назначится задача
'authorid' => 1, // автор задач на случай если контакт не опредеоен
'checkorder' => true, // проверка, есть ли активный заказ, в который можно дописаться
'processor' => 'classname', // имя класса-процессора для пост-обработки
);
// для звонков на номер
$a['601'] = array(
'workflowid' => 3, // бизнес-процесс для старта задачи
'managerid' => 3, // менеджер на которого назначится задача
'authorid' => 1, // автор задач на случай если контакт не опредеоен
'checkorder' => true, // проверка, есть ли активный заказ, в который можно дописаться
'processor' => 'classname', // имя класса-процессора для пост-обработки
);
Engine::Get()->setConfigField('project-box-event-to-issue', $a);

// включить окошко входящего звонка по AMI
Engine::Get()->setConfigField('project-box-call-window', true);
// timeout, по которому OneBox обращается к файлу voip.json и на основании которого показывает
// окошко call-window.
// По умолчанию 1000 ms (1 секунда).
Engine::Get()->setConfigField('call-window-timeout', 1000);

// номер проекта, в который создавать задачи-уведомления
Engine::Get()->setConfigField('project-box-notify-workflowid', 4);

// реестр уведомлений
$a = array();
$a[] = 'BoxNotify_WorkToday';
$a[] = 'BoxNotify_OrderEmpty';
$a[] = 'BoxNotify_OrderBalance';
$a[] = 'BoxNotify_Meeting';
$a[] = 'BoxNotify_ContactField';
$a[] = 'BoxNotify_UnknownEmail'; // только за последний месяц
// $a[] = 'BoxNotify_UnknownEmailFull'; // за все времяя
$a[] = 'BoxNotify_UnknownPhone';
$a[] = 'BoxNotify_UnknownSkype';
$a[] = 'BoxNotify_Documents';
$a[] = 'BoxNotify_ContractsLegal';
$a[] = 'BoxNotify_ManagerNoActions';
$a[] = 'BoxNotify_IncorrectPhone';
$a[] = 'BoxNotify_ServiceBusyConflict';
$a[] = 'BoxNotify_ServiceBusyLong';
$a[] = 'BoxNotify_PredictionEvent';
$a[] = 'BoxNotify_PaymentFeedback';
$a[] = 'BoxNotify_Birthday';
$a[] = 'BoxNotify_ContactNoManager';
$a[] = 'BoxNotify_ContactNoEvent';
$a[] = 'BoxNotify_ContactLongEvent';
$a[] = 'BoxNotify_EmailReply';
$a[] = 'BoxNotify_WebProductionOrders';
$a[] = 'BoxNotify_MissedCall';
Engine::Get()->setConfigField('project-box-notify', $a);

// для уведомления BoxNotify_UnknownPhone минимально сколько должно быть звонков
// по умолчанию число 1
Engine::Get()->setConfigField('box-notify-unknownphone-limit', 1);

// для уведомления BoxNotify_UnknownEmail минимально сколько должно быть писем
// по умолчанию число 1
Engine::Get()->setConfigField('box-notify-unknownemail-limit', 1);

// путь к php, нужен для генерации PDF
Engine::Get()->setConfigField('php-cgi-path', '/usr/bin/php');

// подключение к Asterisk AMI
$a = array();
$a['host'] = 'host';
$a['port'] = 5038;
$a['login'] = 'login';
$a['password'] = 'password';
Engine::Get()->setConfigField('asterisk-ami', $a);

// контексты входящих и исходящих звонков для Asterisk AMI
// по умолчанию office-calls и outgoing-calls
Engine::Get()->setConfigField('asterisk-ami-context-in', 'yazz-calls');
Engine::Get()->setConfigField('asterisk-ami-context-out', 'yazz-outgoing-calls');

// подключение IMAP почты
// @deprecated
// Внимание! Эта настройка уже доступна в интерфейсе OneBox
$a = array();
$a[] = array(
'host' => 'host',
'username' => 'login',
'password' => 'password',
// port => '143',
// name => 'email', // если не задать, используется username
);
Engine::Get()->setConfigField('project-box-event-parser-imap', $a);


// за какой период перепроверять события и их параметры?
// по умолчанию 5 дней (если не задать этот парамтер)
Engine::Get()->setConfigField('project-box-event-parser-check-day', 5);


// информация о звонках берется из таблицы CDR,
// но сами файлы по требованию загружаются с FTP-сервера
$a = array(
'host' => 'voip.server.domain',
'login' => 'login',
'password' => 'password',
'port' => 21,
//'path' => 'records',
);
Engine::Get()->setConfigField('project-box-event-call-ftp', $a);

// включение режима сетки занятости
Engine::Get()->setConfigField('project-box-servicebusy', true);

// разрешить индивидуальные имена заказов
// @todo
Engine::Get()->setConfigField('project-box-custom-order-name', true);

// дополнительные поля в карточку контакта
$a = array();
$a['code1c'] = array(
'name' => 'Код 1C (ИНН/БИН)',
'type' => 'string', // text, bool, date, datetime, check
);
Engine::Get()->setConfigField('project-box-customfield-user', $a);

// дополнительные поля в карточку заказа/задачи
$a = array();
$a['orderproductrequest'] = array(
//'workflowid' => 10, // только для заданного workflow
'name' => 'Интересующий продукт',
'type' => 'string', // text, bool, date, datetime, check
);
Engine::Get()->setConfigField('project-box-customfield-order', $a);

// поиск в боксе
Engine::Get()->setConfigField('box-search', array('contact', 'project', 'event', 'issue', 'product', 'document'));

// список контентов для smart-forms
$a = array();
$a['box-workflow-smart-contactadd'] = 'Заполнить карточку контакта';
$a['box-workflow-smart-call'] = 'Позвонить контакту';
$a['box-workflow-smart-aaa'] = 'Заполнить форму ААА';
$a['box-workflow-smart-bbb'] = 'Заполнить форму БББ';
Engine::Get()->setConfigField('box-workflow-smart-contents', $a);

// что показывать во вкладке "Задачи" в проекте
// заказы клиентов
Engine::Get()->setConfigField('content-project-tab-order', 'clientOrder');
// заказы проекта и клиента
Engine::Get()->setConfigField('content-project-tab-order', 'project&clientOrder');
// заказы проекта, а если их нет, то заказы клиента
Engine::Get()->setConfigField('content-project-tab-order', 'project|clientOrder');
// заказы клиента, а если их нет, то заказы проекта
Engine::Get()->setConfigField('content-project-tab-order', 'client|projectOrder');