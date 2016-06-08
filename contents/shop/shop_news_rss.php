<?php
class shop_news_rss extends Engine_Class {

    public function process() {
        PackageLoader::Get()->import('Feed');

        $url = Engine::Get()->getProjectURL();

        $rss = new Feed_CreatorRSS(
        Shop::Get()->getSettingsService()->getSettingValue('shop-name'),
        $url
        );

        $news = Shop::Get()->getNewsService()->getNewsAll();
        $news->setHidden(0);
        while ($x = $news->getNext()) {
            $content = $x->getContentpreview();
            $content = trim(strip_tags($content));
            if (!$content) {
                $content = $x->getContent();
            }

            $rss->addItem(
            $x->getName(),
            $content,
            $url.$x->makeURL(),
            $x->getCdate(),
            $x->getId()
            );
        }

        print $rss->render(true);
        exit();
    }

}