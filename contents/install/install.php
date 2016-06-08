<?php
class install extends Engine_Class {

    public function process() {
        try {
            try {
                // проверка подключения к БД
                ConnectionManager::Get()->getConnectionMySQL()->connect();
                $this->setValue('dbok', true);

                // проверка на пустоту таблицы юзера
                $u = Shop::Get()->getUserService()->getUsersAll();
                $u->setOrder('level', 'DESC');
                $u->setLimitCount(1);
                if ($u->select()) {
                    if ($u->getLevel() >= 2) {
                        // если есть пользователь и он админ то перекидываем на главную
                        $this->_commentModesInEngineMode();
                        header('Location: /');
                    }
                }
            } catch(Exception $e) {
                $this->setValue('dbok', false);
            }

            // Поиск всех шаблонов в каталоге /templates
            // Сделано на случай добавления нового шаблона.
            $templateArray = scandir(PackageLoader::Get()->getProjectPath().'/templates/');
            $a = array();
            foreach ($templateArray as $val) {
                if ($val == '.' || $val == '..') {
                    continue;
                }

                if (strstr($val, 'corporate')) {
                    continue;
                }

                if ($val{0} == '-') {
                    continue;
                }

                $a[] = $val;
            }
            $this->setValue('templatesArray', $a);

            // подключение к базе данных
            if ($this->getArgumentSecure('ok')) {
                try {
                    $dbhost = $this->getControlValue('dbhost');

                    if (!$dbhost) {
                        $dbhost = 'localhost';
                    }

                    $dblogin = $this->getControlValue('dblogin');
                    $dbpass = $this->getControlValue('dbpass');
                    $dbname = $this->getControlValue('dbname');
                    if (!$dbhost && !$dblogin && !$dbname && !$dbpass) {
                        throw new ServiceUtils_Exception('Empty fields!');
                    }

                    // проверка подключения к БД
                    ConnectionManager::Get()->addConnectionDatabase(
                        new ConnectionManager_MySQL(
                            $dbhost,
                            $dblogin,
                            $dbpass,
                            $dbname
                        )
                    );
                    ConnectionManager::Get()->getConnectionMySQL()->connect();
                    ConnectionManager::Get()->getConnectionDatabase();

                    // если успечно подключились то создаём engine.mode.php
                    $this->_createEngineMode($dbhost, $dblogin, $dbpass, $dbname, $this->getArgumentSecure('template'));

                    $this->setValue('message', 'connectok');
                } catch (Exception $e) {
                    $this->setValue('message', 'connecterror');
                    SQLObject::TransactionRollback();
                }
            }

            if ($this->getArgumentSecure('userok')) {
                $this->_commentModesInEngineMode();

                try {
                    SQLObject::TransactionStart();

                    $pass1 = $this->getControlValue('pass1');
                    $pass2 = $this->getControlValue('pass2');

                    if ((empty($pass1) || empty($pass2)) || ($pass1 != $pass2)) {
                        throw new ServiceUtils_Exception('pass');
                    }
                    $tmpUser = new XUser;
                    $tmpUser->setId(999);
                    $tmpUser->insert();

                    $user = Shop::Get()->getUserService()->addUser(
                        $this->getControlValue('login'),
                        $this->getControlValue('pass1'),
                        $this->getControlValue('email'),
                        false,
                        false,
                        false,
                        false,
                        false,
                        3
                    );

                    $tmpUser->delete();

                    $this->_changeLanguage($this->getControlValue('language'));
                    $this->_changeCurrencyDefault($this->getControlValue('currency'));

                    SQLObject::TransactionCommit();

                    $this->setValue('message', 'userok');
                    $this->setValue('userLogin', $user->getLogin());
                    $this->setValue('userPass', $this->getControlValue('pass1'));
                    $this->setValue('userEmail', $user->getEmail());

                    // получаем значения файла crontab.txt
                    $cronData = file_get_contents(PROJECT_PATH.'cron/crontab.txt');
                    $cronData = str_replace('[wwwpath]', PROJECT_PATH, $cronData);
                    $this->setValue('cronTab', nl2br($cronData));

                } catch(ServiceUtils_Exception $ge) {
                    SQLObject::TransactionRollback();

                    $this->setValue('message', 'usererror');
                    $this->setValue('errorsArray', $ge->getErrorsArray());
                }
            }
        } catch (Exception $e) {

        }
    }

    /**
     * Коментируем development и debug моды в engine.mode.php
     */
    private function _commentModesInEngineMode() {
        $file = 'engine.mode.php';
        $text = file_get_contents($file);
        $textArray = explode("\n", $text);

        $build = "PackageLoader::Get()->setMode('build');";
        $debug = "PackageLoader::Get()->setMode('debug');";

        if (!in_array("//$build", $textArray)) {
            $text = str_replace($development, "//".$build, $text);
        }

        if (!in_array("//$debug", $textArray)) {
            $text = str_replace($debug, "//".$debug, $text);
        }

        file_put_contents($file, $text, LOCK_EX);
    }

    /**
     * Устанавливаем язык сайта
     *
     * @param $lang
     */
    private function _changeLanguage($lang) {
        if (Engine::Get()->getConfigFieldSecure('language-site')) {
            return '';
        }

        $langArray = array('ru', 'ua', 'en');
        if (!$lang || !in_array($lang, $langArray)) {
            $lang = 'ru';
        }

        $file = 'engine.mode.php';
        $text = file_get_contents($file);
        $text .= "
// язык сайта по умолчанию: ru
// можно указать: en, ua, ru
Engine::Get()->setConfigField('language-site', '$lang');";

        file_put_contents($file, $text, LOCK_EX);
    }

    /**
     * Устанавливаем язык сайта
     *
     * @param $lang
     */
    private function _changeCurrencyDefault($currencyName) {
        if (Engine::Get()->getConfigFieldSecure('currency-default')) {
            return '';
        }

        $currencyArray = array('UAH', 'USD', 'RUB', 'EUR');
        if (!$currencyName || !in_array($currencyName, $currencyArray)) {
            $currencyName = 'UAH';
        }

        $file = 'engine.mode.php';
        $text = file_get_contents($file);
        $text .= "
// базовая валюта сайта по умолчанию: UAH
// можно указать: UAH, USD, RUB, EUR
Engine::Get()->setConfigField('currency-default', '$currencyName');";

        file_put_contents($file, $text, LOCK_EX);

        // Базовая валюта
        try {
            // обнулим текщую
            $currency = new XShopCurrency();
            while ($c = $currency->getNext()) {
                $c->setDefault(0);
                $c->update();
            }
            $c = Shop::Get()->getCurrencyService()->getCurrencyByName($currencyName);
            $c->setDefault(1);
            $c->update();
        } catch (Exeption $e) {

        }
    }

    /**
     * создаём engine.mode.php
     */
    private function _createEngineMode($dbhost, $dblogin, $dbpass, $dbname, $template) {
        $host = Engine::GetURLParser()->getHost();
        $file = 'engine.mode.php';
        $fileContent = "<?php
/**
 * OneBox
 * @copyright (C) 2011-2013 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

PackageLoader::Get()->setMode('build');

//Engine::Get()->enableErrorReporting();

Engine::Get()->setConfigField('project-host', '{$host}');

// connection to database
ConnectionManager::Get()->addConnectionDatabase(
new ConnectionManager_MySQLi(
'{$dbhost}',
'{$dblogin}',
'{$dbpass}',
'{$dbname}'
));

";
        if ($template && $template != 'basic') {
            $fileContent .= "Engine::Get()->setConfigField('shop-template', '{$template}');";
        }

        file_put_contents($file, $fileContent, LOCK_EX);
    }
}