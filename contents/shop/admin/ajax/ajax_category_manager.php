<?php
class ajax_category_manager extends Engine_Class {

    public function process() {
        $a = $this->getArgumentSecure('listArray');
        if ($a) {
            $a = explode('&', $a);
            // строим массив ключ - id категории, значение - id родителя
            $categoryArray = array();
            foreach ($a as $val) {
                // получаемые значения хранятся в виде list[$id] = $parentId,
                // если парента нету, list[$id] = null
                $tmp = explode('=', $val);
                // убераем лишнее, оставляем только число
                $id = preg_replace("/\D/", "", $tmp[0]);
                $parentID = $tmp[1];
                $categoryArray[$id] = $parentID;
            }
            $index = 0;
            foreach ($categoryArray as $id => $parentID) {
                try {
                    SQLObject::TransactionStart();
                    $category = Shop::Get()->getShopService()->getCategoryByID($id);
                    if ($category->getParentid() != $parentID || $category->getSort() != $index) {
                        $category->setParentid($parentID);
                        $category->setSort($index);
                    }
                    $category->update();

                    $index++;
                    SQLObject::TransactionCommit();
                } catch (ServiceUtils_Exception $e) {
                    SQLObject::TransactionRollback();
                }
            }

            $productBuildTask = new XShopBuildProductCategoryTask();
            $productBuildTask->setCdate(DateTime_Object::Now());
            $productBuildTask->setPdate('0000-00-00 00:00:00');
            if (!$productBuildTask->select()) {
                $productBuildTask->insert();
            }
            exit;
        }
    }

}