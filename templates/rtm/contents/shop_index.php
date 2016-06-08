<?php
class shop_index extends Engine_Class {

    public function process() {

        $this->_addCanonicalLink();
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
        while ($x = $lists->getNext()) {
            try {
                $showtype = $x->getShowtype();
                if (!$showtype) {
                    $showtype = 'carousel';
                }

                $l['id'] = $x->getId();
                $l['name'] = $x->makeName();
                $l['html'] = $x->render();

                if ($showtype == 'carousel') {
                    $a[] = $l;
                } else {
                    $b[] = $l;
                }

            } catch (Exception $e) {

            }
        }

        $this->setValue('carouselArray', $a);
        $this->setValue('tabsArray', $b);
    }

    private function _addCanonicalLink() {
        if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $h = 'https://';
        } else {
            $h = 'http://';
        }
        $url = $h.Engine::Get()->getProjectHost();
        //Engine::GetHTMLHead()->addLink('canonical', $url.'/');
    }

}