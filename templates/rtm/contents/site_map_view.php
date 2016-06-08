<?php
class site_map_view extends Engine_Class {

    public function process() {
        $this->setValue('textpageArray', $this->_makeTextpageArray());
        $this->setValue('urlformainpage',Engine::Get()->getConfigField('project-host'));

        $this->setValue('shopUrl', 'http://'.Engine::Get()->getConfigField('project-host').'/');

        $this->setValue('mainCategoryArray', $this->_getCategoryArray());

        $this->setValue('main', Engine::Get()->getProjectURL());
    }

    private function _makeTextpageArray($parentID = 0) {
        // загружаем все текстовые страницы в один список
        $pageArray = Shop::Get()->getTextPageService()->getTextPageArray();
        $a = array();
        foreach ($pageArray as $x) {
            if ($x->getHidden()) {
                continue;
            }

            $selected = false;
            if (Engine::Get()->getRequest()->getContentID() == 'shop-page') {
                $selected = ($x->getId() == $this->getArgumentSecure('id'));
            }

            $a[$x->getParentid()][] = array(
                'id' => $x->getId(),
                'parentid' => $x->getParentid(),
                'btnName' => $x->getBtnname(),
                'name' => $x->makeName(),
                'image' => $x->makeImage(),
                'url' => $x->makeURL(),
                'selected' => $selected,
            );
        }

        // переделываем список на двухуровневый
        $b = array();
        if (isset($a[0])) {
            foreach ($a[0] as $x) {
                $x['childArray'] = @$a[$x['id']];
                $b[] = $x;
            }
        }

        return $b;
    }

    private function _getCategoryArray() {
        $subcategories = Shop::Get()->getShopService()->getCategoryAll();
        $subcategories->setHidden(0);
        $subcategories->setParentid(0);

        $a = array();
        while ($x = $subcategories->getNext()) {
            $childs = Shop::Get()->getShopService()->getCategoriesByParentID($x->getId());
            $childs->setHidden(0);
            $childsArray = array();

            while ($y = $childs->getNext()) {
                $url = $y->makeURL();
                $childsArray[] = array(
                    'name' => $y->makeName(),
                    'url' => $url
                );
            }

            $image = false;

            if ($x->makeImageThumb()) {
                $image = $x->makeImageThumb();
            } else {
                $product = Shop::Get()->getShopService()->getProductsByCategory($x);
                $product->addWhere('image', '', '<>');
                $product->setLimitCount(1);
                if ($w = $product->getNext()){
                    $image = $w->makeImageThumb(200);
                }
            }
            $url = $x->makeURL();
            $a[] = array(
                'name' => $x->makeName(),
                'url' => $url,
                'image' => $image,
                'childsArray' => $childsArray,
            );
        }
        return $a;
    }

}