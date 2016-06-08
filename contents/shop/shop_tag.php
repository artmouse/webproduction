<?php
class shop_tag extends Engine_Class {

    public function process() {
        try {
            $tag = Shop::Get()->getShopService()->getProductTagByID(
                $this->getArgument('id')
            );
        } catch (Exception $e) {
            // бросаем exception для 404
            $e->setCode(404);
            throw $e;
        }

        $title = Shop::Get()->getSettingsService()->getSettingValue('seo-title-tag');
        $title = str_replace('[name]', $tag->makeName(true), $title);

        Engine::GetHTMLHead()->setTitle(
            htmlspecialchars($title)
        );

        $this->setValue('seoh1', $tag->makeName(true));
        $this->setValue('description', $tag->getDescription());

        // SEO-контекнт передаем в shop-tpl
        $tpl = Engine::GetContentDriver()->getContent('shop-tpl');
        $tpl->setValue('seocontent', $tag->getDescription());

        // ------------------------------------------------- //

        // open graph tags
        Engine::GetHTMLHead()->setMetaTag('og:title', $tag->makeName(true));
        Engine::GetHTMLHead()->setMetaTag('og:description', htmlspecialchars(strip_tags($tag->getDescription())));

        // ------------------------------------------------- //

        $productTags = new XShopProduct2Tag();
        $productTags->setTagid($tag->getId());
        $productIDArray = array(-1);
        while ($x = $productTags->getNext()) {
            $productIDArray[] = $x->getProductid();
        }

        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setHidden(0);
        $products->setDeleted(0);
        $products->addWhereArray($productIDArray);

        $render = Engine::GetContentDriver()->getContent('shop-product-list');
        $render->setValue('items', $products);
        $render->setValue('filtercategory', true);
        $render->setValue('filterbrand', true);
        $render->setValue('filtervalue', true);
        $render->setValue('pathArray', $this->_makePathArray($tag));
        $this->setValue('items', $render->render());

        $this->setValue('pathAdditionalH1', $render->getValue('pathAdditionalH1'));
    }

    /**
     * Построить путь тега
     *
     * @param ShopProductTag $tag
     *
     * @return array
     */
    private function _makePathArray(ShopProductTag $tag) {
        $a = array();

        try {
            $a[] = array(
            'name' => $tag->makeName(),
            'url' => $tag->makeURL(),
            );
        } catch (Exception $e) {

        }
        return $a;
    }

}