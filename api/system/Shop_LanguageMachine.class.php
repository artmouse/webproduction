<?php
class Shop_LanguageMachine implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        if (!file_exists(PackageLoader::Get()->getProjectPath() . '/modules/multilanguage/include.php')) {
            return;
        }

        $modulesArray = Engine::Get()->getConfigField('shop-module');
        if (!in_array('multilanguage', $modulesArray)) {
            return;
        }

        include_once(PackageLoader::Get()->getProjectPath() . '/modules/multilanguage/include.php');

        // Блок обработки языка
        // здесь нужен полный массив языков - с дефолтным
        $shopLanguageArrayCustom = Engine::Get()->getConfigFieldSecure('shopLanguageArrayCustom');
        $shopLanguageArrayCustom = array_keys($shopLanguageArrayCustom);
        @session_start();
        $host = Engine::GetURLParser()->getHost();
        $hostParts = explode('.', $host, 2);

        $lang = '';
        $sessionLang = '';
        // язык с сессии
        if (isset($_SESSION['sessionLang'])) {
            $sessionLang = $_SESSION['sessionLang'];
        }

        $lang = $hostParts[0];

        if (!in_array($lang, $shopLanguageArrayCustom)) {
            $lang = $sessionLang;
        }

        // это если работает в кастомном модуле определение страны по ip
        if (isset($_SESSION['sessionGeoLang']) && !$sessionLang) {
            $lang = $_SESSION['sessionGeoLang'];
        }

        $arguments = Engine::GetURLParser()->getArguments();

        // print_r($arguments);exit;

        // проверить аргумент на смену языка
        if (isset($arguments['shopSiteLanguage']) && $arguments['shopSiteLanguage'] != $lang) {
            if (in_array($arguments['shopSiteLanguage'], $shopLanguageArrayCustom)) {
                $lang = $arguments['shopSiteLanguage'];
            }
        }

        // если определенного языка нету, ставим по умолчанию
        if (!in_array($lang, $shopLanguageArrayCustom)) {
            $lang = $shopLanguageArrayCustom[0];
        }

        // Если поддомен не совпадает с языком, редирект
        if (!Engine::Get()->getConfigFieldSecure('shopLanguageNoDomain')) {
            if ($hostParts[0] && $hostParts[0] != $lang) {
                if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                    $h = 'https://';
                } else {
                    $h = 'http://';
                }

                // @session_destroy();
                $u = $h . $lang . '.' . Engine::Get()->getProjectHost() . Engine::GetURLParser()->getTotalURL();
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: ' . $u);
                exit();
            }
        }

        $_SESSION['sessionLang'] = $lang;
        Engine::Get()->setConfigField('language-site', $lang);
    }

}