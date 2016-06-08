<?php
class block_news extends Engine_Class {

    public function process() {
        // новости и статьи
        try {
            $news = Shop::Get()->getNewsService()->getNewsAll();
            $news->setHidden(0);
            $news->setLimitCount(3);

            // определяем, где мы сейчас находимся
            // и в зависимости от этого формируем статьи
            $brand = $this->getValue('brand');
            if ($brand) {
                $news->setBrandid($brand->getId());
            }

            $category = $this->getValue('category');
            if ($category) {
                $news->setCategoryid($category->getId());
            }

            // issue #37100 - новости только на главной
            // или в связанных категориях/брендах
            $url = Engine::GetURLParser()->getTotalURL();
            if ($url != '/' && !$brand && !$category) {
                return;
            }

            $a = array();
            while ($x = $news->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                'preview' => $x->getContentpreview(),
                'date' => DateTime_Formatter::DatePhonetic($x->getCdate()),
                'url' => $x->makeURL(),
                );
            }
            $this->setValue('newsArray', $a);

            try {
                $page = Shop::Get()->getTextPageService()->getTextPageByLogicclass('shop-news');
                $this->setValue('url', $page->makeURL());
            } catch (Exception $urlEx) {

            }
        } catch(Exception $e) {

        }
    }

}