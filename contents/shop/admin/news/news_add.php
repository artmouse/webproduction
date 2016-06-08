<?php
class news_add extends Engine_Class {

    public function process() {
        PackageLoader::Get()->import('CKFinder');

        if ($this->getArgumentSecure("formsInsert")) {
            try {
                $image = $this->getArgumentSecure("image");
                $image = @$image['tmp_name'];

                Shop::Get()->getNewsService()->addNews(
                $this->getArgumentSecure("cdate"),
                $this->getArgumentSecure("hidden"),
                $this->getArgumentSecure("name"),
                $this->getArgumentSecure("contentpreview"),
                $this->getArgumentSecure("content"),
                $image,
                $this->getArgumentSecure("addproduct"),
                $this->getArgument("category"),
                $this->getArgument("brand"),
                false,
                $this->getArgumentSecure("seodescription"),
                $this->getArgumentSecure("seotitle"),
                $this->getArgumentSecure("seocontent"),
                $this->getArgumentSecure("seokeywords")
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