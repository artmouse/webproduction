<?php
class priceplaces_index extends Engine_Class {

    public function process() {
        $ppID = $this->getArgumentSecure('id');

        $pp = new XShopExportPlace();
        $pp->setOrder('name');
        $a = array();
        while ($x = $pp->getNext()) {
            $a[] = array(
            'name' => $x->getName(),
            'url' => Engine::GetLinkMaker()->makeURLByContentIDParam($this->getContentID(), $x->getId()),
            'selected' => ($x->getId() == $ppID),
            'link' => Engine::Get()->getProjectURL().'/media/export/'.$x->getId().'.xml',
            'urlview' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-priceplaces-view', $x->getId()),
            );
        }
        $this->setValue('ppArray', $a);

        if ($ppID) {
            $this->setValue('url', Engine::Get()->getProjectURL().'/media/export/'.$ppID.'.xml');

            // сохраняем
            if ($this->getControlValue('ok')) {
                try {
                    // удаляем старые связи
                    $this->_deleteOldRelations($ppID);

                    SQLObject::TransactionStart();

                    $categoryArray = $this->getArgument('category');
                    if (!$categoryArray) {
                        $categoryArray = array();
                    }

                    // добавляем новые
                    foreach ($categoryArray as $id) {
                        $links = new XShopExportPlaceCategory();
                        $links->setPlaceid($ppID);
                        $links->setCategoryid($id);
                        $links->insert();
                    }

                    SQLObject::TransactionCommit();
                    $this->setValue('message', 'ok');
                } catch (Exception $ge) {
                    SQLObject::TransactionRollback();
                    $this->setValue('message', 'error');
                }
            }

            // строим список/дерево категорий
            $a = $this->_makeCategoryArray();
            $b = array();
            foreach ($a as $info) {
                $link = new XShopExportPlaceCategory();
                $link->setPlaceid($ppID);
                $link->setCategoryid($info['id']);
                $info['selected'] = $link->select();

                $b[] = $info;
            }
            $this->setValue('categoryArray', $b);
        }
    }

    /**
     * @param $ppID
     * @throws Exception
     */
    private function _deleteOldRelations( $ppID ) {
        try{

            SQLObject::TransactionStart();
            // удаляем старые связи
            $links = new XShopExportPlaceCategory();
            $links->setPlaceid($ppID);
            while ( $x = $links->getNext() ) {
                $x->delete();
            }

            SQLObject::TransactionCommit();

        } catch ( Exception $ge ) {
            SQLObject::TransactionRollback();
            throw new Exception($ge);
        }
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