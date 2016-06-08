<?php
class Kazakh {


    public function getKazakhService() {
        return ServiceUtils::Get()->getService('KazakhService');
    }

    public function genetateSitemap() {

        PackageLoader::Get()->import('Sitemap');
        // создаем генератор sitemaps'a
        $sitemap = new Sitemap(Engine::Get()->getProjectHost());

        // все текстовые страницы
        $pages = Shop::Get()->getTextPageService()->getTextPageAll();
        $pages->setHidden(0);
        while ($x = $pages->getNext()) {
            $sitemap->addURL($x->makeURL().'/');
        }

        $sitemap->addURL('http://hotel-kazakhfilm-almaty.kz/transfer/');
        $sitemap->addURL('http://hotel-kazakhfilm-almaty.kz/booking/');
        $sitemap->addURL('http://hotel-kazakhfilm-almaty.kz/guestbook');
        $sitemap->addURL('http://hotel-kazakhfilm-almaty.kz/contacts/');
        $sitemap->addURL('http://hotel-kazakhfilm-almaty.kz/transfer/');
        $sitemap->render(PackageLoader::Get()->getProjectPath());
    }


    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __construct() {

    }

    private function __clone() {

    }

    private static $_Instance = null;

}