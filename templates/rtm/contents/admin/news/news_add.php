<?php
class news_add extends Engine_Class {

    public function process() {
        PackageLoader::Get()->import('CKFinder');

        $page = Shop::Get()->getTextPageService()->getTextPageAll();
        $page->setLogicclass('shop-news');
        $this->setValue('pageArray',$page->toArray());

        if ($this->getArgumentSecure("formsInsert")) {
            try {
                $image = $this->getArgumentSecure("image");
                $image = @$image['tmp_name'];

                RtmService::Get()->addNews(
                    $this->getArgumentSecure("cdate"),
                    $this->getArgumentSecure("hidden"),
                    $this->getArgumentSecure("name"),
                    $this->getArgumentSecure("contentpreview"),
                    $this->getArgumentSecure("content"),
                    $image,
                    $this->getArgumentSecure("addproduct"),
                    $this->getArgument("category"),
                    $this->getArgument("brand"),
                    $this->getArgumentSecure("url"),
                    $this->getArgumentSecure("seodescription"),
                    $this->getArgumentSecure("seotitle"),
                    $this->getArgumentSecure("seocontent"),
                    $this->getArgumentSecure("seokeywords"),
                    $this->getControlValue("pageid")
                );

                $this->setValue('message', 'ok');

                header("location: /admin/shop/news/");
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $e->getErrors());
            }
        }

        // список брендов
        $brands = Shop::Get()->getShopService()->getBrandsAll();
        $this->setValue('brandsArray', $brands->toArray());

        // категории
        $this->setValue('categoryArray', $this->_makeCategoryArray());
    }

    /**
     * @return array
     */
    private function _makeCategoryArray() {
        // строим массив всех категорий
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $a = array();
        while ($x = $category->getNext()) {
            $a[$x->getParentid()][] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'selected' => $x->getId() == $this->getArgumentSecure('categoryid'),
                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $x->getId())),
                'parentid' => $x->getParentid(),
            );
        }

        return $this->_makeCategoryTree(0, 0, $a);
    }

    private function _makeCategoryTree($parentID, $level, $categoryArray) {
        $a = array();
        if (empty($categoryArray[$parentID])) {
            return $a;
        }
        foreach ($categoryArray[$parentID] as $x) {
            $x['level'] = $level;
            $a[] = $x;
            $childs = $this->_makeCategoryTree($x['id'], $level + 1, $categoryArray);
            foreach ($childs as $y) {
                $a[] = $y;
            }
        }
        return $a;
    }

}