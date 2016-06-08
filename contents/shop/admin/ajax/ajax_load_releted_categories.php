<?php
class ajax_load_releted_categories extends Engine_Class {

    public function process() {

        $a = array();

        if ($ids = $this->getArgumentSecure('ids')) {
            $ids = explode(',', $ids);

            foreach ($ids as $categoryID) {
                $x = new XShopReletedCategory();
                $x->setCategoryid($categoryID);

                while( $relation = $x->getNext() ) {
                    try {
                        $category = Shop::Get()->getShopService()->getCategoryByID($relation->getReletedcategoryid());
                        $a[] = array(
                            'name' => $category->getName(),
                            'id' => $category->getId()
                        );
                    } catch (Exception $e) {

                    }
                }

            }
        }

        // выдача результатов
        echo json_encode($a);
        exit;
    }

}