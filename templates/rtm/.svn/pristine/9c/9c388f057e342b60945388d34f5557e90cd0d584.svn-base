<?php
class news_control extends Engine_Class {

    public function process() {
        try {
            PackageLoader::Get()->import('CKFinder');
            CKFinder_Configuration::Get()->setAuthorized(true);

            $page = Shop::Get()->getTextPageService()->getTextPageAll();
            $page->setLogicclass('shop-news');
            $this->setValue('pageArray',$page->toArray());

            $newsID = $this->getArgumentSecure('id');
            if ($newsID) {
                $new_q = Shop::Get()->getNewsService()->getNewsByID($newsID);

                if ($this->getArgumentSecure("formsUpdate")) {
                    try {
                        $image = $this->getArgumentSecure("image");
                        $image = @$image['tmp_name'];

                        RtmService::Get()->updateNews(
                            $new_q,
                            $this->getArgument("cdate"),
                            $this->getArgumentSecure("hidden"),
                            $this->getArgument("name"),
                            $this->getArgument("contentpreview"),
                            $this->getArgument("content"),
                            $image,
                            $this->getArgumentSecure("imagedelete"),
                            $this->getArgument("addproduct"),
                            $this->getArgument("category"),
                            $this->getArgument("brand"),
                            $this->getArgument("url"),
                            $this->getArgument("seodescription"),
                            $this->getArgument("seotitle"),
                            $this->getArgument("seocontent"),
                            $this->getArgument("seokeywords"),
                            $this->getControlValue("pageid")
                        );

                        $this->setValue('message', 'ok');
                    } catch (ServiceUtils_Exception $e) {
                        $this->setValue('message', 'error');
                        $this->setValue('errorArray', $e->getErrorsArray());
                    }
                }

                if ($this->getArgumentSecure("formsDelete")) {
                    Shop::Get()->getNewsService()->deleteNewsByID($newsID);
                    header("location: /admin/shop/news/");
                }

                $this->setControlValue('name', $new_q->getName());
                $this->setControlValue('content', $new_q->getContent());
                $this->setControlValue('contentpreview', $new_q->getContentpreview());
                $this->setControlValue('hidden', $new_q->getHidden());
                $this->setControlValue('cdate', $new_q->getCdate());
                $this->setControlValue("addproduct", $new_q->getProductid());
                $this->setControlValue("brand", $new_q->getBrandid());
                $this->setControlValue("category", $new_q->getCategoryid());
                $this->setControlValue('seotitle', $new_q->getSeotitle());
                $this->setControlValue('seodescription', $new_q->getSeodescription());
                $this->setControlValue('seotext', $new_q->getSeocontent());
                $this->setControlValue('seokeywords', $new_q->getSeokeywords());
                $this->setControlValue('url', $new_q->getUrl());
                $this->setControlValue('pageid', $new_q->getPageid());

                $this->setValue('image', $new_q->makeImageThumb());
            }
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
            Engine::Get()->getRequest()->setContentNotFound();
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