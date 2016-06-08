<?php
class shop_news_view_key extends Engine_Class {

    public function process() {
        try {
            $page = Shop::Get()->getTextPageService()->getTextPageByID(
            $this->getArgument('id')
            );

            Engine::GetURLParser()->setArgument('id', $page->getKey());

            try {
                $seo = Shop::Get()->getSEOService()->getSEOByURL(
                    Engine::GetURLParser()->getTotalURL()
                );
                if ($seo->getSeoh1()) {

                    $this->setValue('seoh1',$seo->getSeoh1());

                }
            } catch (Exception $seoEx) {

            }

            $content = Engine::GetContentDriver()->getContent('shop-news-view');

            try {
                $seo = Shop::Get()->getSEOService()->getSEOByURL(
                    Engine::GetURLParser()->getTotalURL()
                );
                if ($seo->getSeoh1()) {

                    $content->setValue('seoh1',$seo->getSeoh1());

                }
            } catch (Exception $seoEx) {

            }

            $this->setValue('content', $content->render());
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}