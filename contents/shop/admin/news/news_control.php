<?php
class news_control extends Engine_Class {

    public function process() {
        PackageLoader::Get()->import('CKFinder');

        try {
            PackageLoader::Get()->import('CKFinder');
            CKFinder_Configuration::Get()->setAuthorized(true);
            $newsID = $this->getArgumentSecure('id');
            if ($newsID) {
                $new_q = Shop::Get()->getNewsService()->getNewsByID($newsID);

                if ($this->getArgumentSecure("formsUpdate")) {
                    try {
                        $image = $this->getArgumentSecure("image");
                        $image = @$image['tmp_name'];

                        Shop::Get()->getNewsService()->updateNews(
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
                        false,
                        $this->getArgument("seodescription"),
                        $this->getArgument("seotitle"),
                        $this->getArgument("seocontent"),
                        $this->getArgument("seokeywords")
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

        // список категорий
        $category = Shop::Get()->getShopService()->makeCategoryTree();
        $a = array();
        foreach ($category as $x) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            'hidden' => $x->getHidden(),
            'level' => $x->getField('level'),
            'selected' => $x->getId() == $this->getArgumentSecure('categoryid'),
            'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $x->getId())),
            'parentid' => $x->getParentid(),
            );
        }
        $this->setValue('categoryArray', $a);
    }

}