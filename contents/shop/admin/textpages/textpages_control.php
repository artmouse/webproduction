<?php
class textpages_control extends Engine_Class {

    public function process() {
        $form = new Forms_ContentForm(new Datasource_TextPages());
        PackageLoader::Get()->import('CKFinder');

        $pageID = $this->getArgumentSecure('id');
        try {
            Shop::Get()->getTextPageService()->getTextPageByParentID($pageID);
            $form->denyDelete();
        } catch (Exception $e) {

        }

        $this->setValue('form', $form->render($pageID));
    }

}