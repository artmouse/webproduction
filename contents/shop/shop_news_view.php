<?php
class shop_news_view extends Engine_Class {

    public function process() {
        try {
            $news = Shop::Get()->getNewsService()->getNewsByID(
                $this->getArgument('id')
            );

            try {

                if ($news->getHidden()) {
                    try {
                        if (!$this->getUser()->isAdmin()) {
                            throw new ServiceUtils_Exception();
                        }
                    } catch (Exception $e) {
                        throw new ServiceUtils_Exception();
                    }
                }

                // устанавливаем meta-ключевые слова и описание
                Engine::GetHTMLHead()->setMetaKeywords(htmlspecialchars($news->getSeokeywords()));
                Engine::GetHTMLHead()->setMetaDescription(htmlspecialchars($news->getSeodescription()));

                // устанавливаем title
                Engine::GetHTMLHead()->setTitle($news->getSeotitle()?$news->getSeotitle():$news->getName());

                $this->setValue('date', DateTime_Formatter::DateTimePhonetic($news->getCdate()));
                $this->setValue('name', htmlspecialchars($news->getName()));
                $this->setValue('content', $news->getContent());

                //если добавлена интеграция с системой комментариев disqus
                $this->setValue(
                    'integration_disqus_news',
                    Shop::Get()->getSettingsService()->getSettingValue('integration-disqus-news')
                );

                try {
                    $seo = Shop::Get()->getSEOService()->getSEOByURL(
                        Engine::GetURLParser()->getTotalURL()
                    );
                    if ($seo->getSeoh1()) {
                        $this->setValue('seoh1', $seo->getSeoh1());
                    }
                } catch (Exception $seoEx) {

                }

                // ------------------------------------------------- //

                // SEO-контекнт передаем в shop-tpl
                $tpl = Engine::GetContentDriver()->getContent('shop-tpl');
                $tpl->setValue('seocontent', $news->getSeocontent());

                // ------------------------------------------------- //

                // open graph tags
                $image = $news->makeImageThumb(100);
                if ($image) {
                    Engine::GetHTMLHead()->setMetaTag('og:image', Engine::Get()->getProjectURL().$image);
                }
                Engine::GetHTMLHead()->setMetaTag('og:title', $news->getName());
                Engine::GetHTMLHead()
                    ->setMetaTag('og:description', htmlspecialchars(strip_tags($news->getContentpreview())));

                // ------------------------------------------------- //

                if ($productID = $news->getProductid()) {
                    try {
                        $product = Shop::Get()->getShopService()->getProductByID($productID);

                        // лежит ли товар в корзине
                        $this->setValue('inbasket', $product->isInBasket());
                        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

                        $this->setValue('id', $product->getId());
                        $this->setValue('barcode', $product->getBarcode());
                        $this->setValue('productname', htmlspecialchars($product->getName()));
                        $this->setValue('description', nl2br(htmlspecialchars($product->getDescription())));
                        $this->setValue('image', $product->makeImageThumb(160, 140, 'prop'));
                        $this->setValue('url', $product->makeUrl());
                        $this->setValue('price', $product->makePrice($currencyDefault, false));
                        $this->setValue('discount', $product->getDiscount());
                        $this->setValue('currency', $currencyDefault->getSymbol());
                        $this->setValue('model', htmlspecialchars($product->getModel()));
                        $this->setValue('unit', htmlspecialchars($product->getUnit()));
                        $this->
                        setValue('count', (($product->getDivisibility()>0) ? ((float) $product->getDivisibility()):1));
                        $this->setValue('avail', $product->getAvail());
                        $this->
                        setValue(
                            'canbuy',
                            ($product->getAvail() ||
                            Shop::Get()->getSettingsService()->getSettingValue('product-cansale-unavail'))
                        );
                        $this->setValue('availtext', htmlspecialchars($product->getAvailtext()));
                        $this->setValue('orderurl', $this->makeURL(array('buy' => $product->getId())));

                        $this->setValue('orderurl', $this->makeURL(array('buy' => $product->getId())));
                    } catch(Exception $ge) {

                    }
                }

            } catch (ServiceUtils_Exception $ge) {

                throw new ServiceUtils_Exception('500 Internal Server Error', 500);

            }

        } catch (ServiceUtils_Exception $ge) {

            if ($ge->getCode() == 500) {

                LogService::Get()->add();
                Engine::Get()->getRequest()->setContentServerError();
                return;

            }


            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}