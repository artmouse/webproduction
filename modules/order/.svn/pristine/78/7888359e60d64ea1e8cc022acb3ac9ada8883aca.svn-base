<?php
class order_add_product_list_category_filter extends Engine_Class {

    public function process() {

        $categoryId = $this->getArgument('categoryId');
        if (!$categoryId) {
            return false;
        }

        $category = Shop::Get()->getShopService()->getCategoryByID($categoryId);
        $filterArray = array();
        for ($i=1; $i<=10; $i++) {
            $filterid = $category->getField('filter'.$i.'id');
            if (!$filterid) {
                continue;
            }

            try{
                $filter = Shop::Get()->getShopService()->getProductFilterByID($filterid);
                $filterArray[] = array(
                    'id' => $filter->getId(),
                    'name' => $filter->getName()
                );
            } catch (Exception $fe) {

            }

        }

        $this->setValue('filterArray', $filterArray);
    }

}