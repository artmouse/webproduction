<?php
class textpages_index extends Engine_Class {

    public function process() {
        $this->setValue('pagesArray', $this->_makeTree());
        PackageLoader::Get()->import('CKFinder');
        CKFinder_Configuration::Get()->setAuthorized(true);
        $pageID = $this->getArgumentSecure('open');
        if ($pageID) {
            try {
                $form = new Forms_ContentForm(new Datasource_TextPages(false));
                $form->denyInsert();
                try {
                    Shop::Get()->getTextPageService()->getTextPageByParentID($pageID);
                    $form->denyDelete();
                } catch (Exception $e) {

                }

                $va = $form->getField('parentid')->getValidatorsArray();
                $va[0]->setDisallowID($pageID);

                $this->setValue('form', $form->render($pageID));
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }

                Engine::Get()->getRequest()->setContentNotFound();
            }
        }
    }


    private function _makeTree() {
        $pages = new XShopTextPage();
        $pages->setOrder('sort', 'ASC');
        $a = array();
        while ($x = $pages->getNext()) {
            $a[$x->getParentid()][] = array(
                'id' => $x->getId(),
                'parentid' => $x->getParentid(),
                'name' => htmlspecialchars($x->getName()),
                'url' => Engine::GetLinkMaker()->makeURLByContentIDParam($this->getContentID(), $x->getId(), 'open'),
                'selected' => $this->getArgumentSecure('open') == $x->getId() ? true : false
            );
        }
        return $a;
    }

}