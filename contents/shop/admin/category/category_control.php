<?php
class category_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_Category());
            PackageLoader::Get()->import('CKFinder');
            $categoryID = $this->getArgumentSecure('key');
            try {
                $category = Shop::Get()->getShopService()->getCategoryByID($categoryID);
                if (0 != $category->getParentid()) {
                     $form->getDataSource()->getField('subdomain')->setEditable(false);
                }
                
                if ($category->getChilds()->getCount()
                || $category->getProducts()->getCount()
                ) {
                    $form->denyDelete();
                }
            } catch (Exception $e) {
                $form->getDataSource()->getField('subdomain')->setEditable(false);
            }

            if (!$categoryID) {
                // делаем поле ID редактируемым
                $form->getDataSource()->getField('id')->setEditable(true);
                $form->getDataSource()->getField('id')->setName(
                    Shop::Get()->getTranslateService()->getTranslateSecure('translate_kod_kategorii_ne_obyazatelno')
                );
            } else {
                $va = $form->getField('parentid')->getValidatorsArray();
                $va[0]->setDisallowID($categoryID);
            }

            $this->setValue('form', $form->render($categoryID));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }

    }

}