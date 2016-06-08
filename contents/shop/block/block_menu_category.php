<?php
class block_menu_category extends Engine_Class {

    public function process() {
        $this->setValue('categoryArray', $this->_makeChildArray(0));
    }

    private function _makeChildArray($parentId) {
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $category->setParentid($parentId);
        $category->setHidden(0);

        if ($category->getLevel() > 3) {
            return false;
        }
        $categoryArray = array();

        while ($x = $category->getNext()) {
            if (in_array($x->getId(), $this->_checkArray)) {
                return false;
            }

            $this->_checkArray[] = $x->getId();

            $a = array();
            $a['name'] = $x->getName();
            $a['id'] = $x->getId();
            $a['url'] = $x->makeURL();
            $a['childsArray'] = $this->_makeChildArray($x->getId());
            $a['selected'] = $x->getId() == $this->getValue('categorySelected');
            $a['productCount'] = $x->getProductcount();

            $categoryArray[] = $a;
        }

        return $categoryArray;
    }

    private $_checkArray = array();

}