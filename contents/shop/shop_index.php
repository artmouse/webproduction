<?php
class shop_index extends Engine_Class {

    public function process() {
        // списки товаров для главной страницы
        $this->_makeListsArray();

        // SEO текст на главную
        try {
            $this->setValue(
            'seotextinindexpage',
            Shop::Get()->getSettingsService()->getSettingValue('seo-text-in-index-page')
            );
        } catch (Exception $e) {

        }
    }

    /**
     * Построить списки товаров на главную
     *
     * @return array
     */
    private function _makeListsArray() {
        // получаем все списки для главной страницы
        $lists = Shop::Get()->getShopService()->getProductsListAll();
        $lists->setHidden(0);
        $lists->setShowinmain(1);

        $a = array(); // carousel
        $b = array(); // tabs
        $c = array(); // наборы
        while ($x = $lists->getNext()) {
            try {
                $showtype = $x->getShowtype();
                if (!$showtype) {
                    $showtype = 'carousel';
                }

                $l = array();
                $l['id'] = $x->getId();
                $l['name'] = $x->makeName();
                if ($showtype != 'set') {
                    $l['html'] = $x->render();
                } else {
                    $l['imageThumb'] = $x->makeImageThumb(100);
                    $l['image'] = $x->getSetimage();
                    $l['url'] = Engine::GetLinkMaker()->makeURLByContentIDParam('shop-product-set',$x->getId());
                }

                if ($showtype == 'carousel') {
                    $a[] = $l;
                } elseif ($showtype == 'set') {
                    $c[] = $l;
                } else {
                    $b[] = $l;
                }

            } catch (Exception $e) {

            }
        }
        $this->setValue('carouselArray', $a);
        $this->setValue('tabsArray', $b);
        $this->setValue('setArray', $c);
    }

}