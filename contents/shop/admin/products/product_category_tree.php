<?php
class product_category_tree extends Engine_Class {

    public function process() {

        $this->setValue('categoryArray', $this->_makeCategoryArray());
        $this->setValue('newCategoryArray', $this->_makeCategoryArray2());

    }

    /**
     * Постороить дерево категорий
     *
     * @return array
     */
    private function _makeCategoryArray2() {
        // строим массив всех категорий
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $a = array();
        while ($x = $category->getNext()) {
            $a[$x->getParentid()][] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'selected' => $x->getId() == $this->getArgumentSecure('categoryid'),
                'url' => Engine::GetLinkMaker()->makeURLByContentIDParams(
                    'shop-admin-products-inlist',
                    array('categoryid' => $x->getId())
                ),
                'parentid' => $x->getParentid(),
            );
        }

        return $a;
    }

    /**
     * Постоить дерево категорий
     *
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
                'url' => Engine::GetLinkMaker()->makeURLByContentIDParams(
                    'shop-admin-products-inlist',
                    array('categoryid' => $x->getId())
                ),
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