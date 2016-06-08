<?php
class report_image extends Engine_Class {

    public function process() {
        set_time_limit(10*60); // устанавливаем время работы 

        $datereport = DateTime_Formatter::DateTimeRussianGOST(DateTime_Object::Now());
        $categoryID = $this->getArgumentSecure('categoryid', 'int');
        $productArray = array();
        $namecurrentcategory = 'Не выбрано';
        
        if ($categoryID) {
            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->setDeleted(0);
            if ($categoryID > 0) {
                $products->setCategoryid($categoryID);
            }
            while ($product = $products->getNext()) {
                $fotocnt = 0;
                $fotofile = 0;
                $categoryname = '';

                $category = new XShopCategory();
                $category->setId($product->getCategoryId());
                if ($category->select()) {
                    $categoryname = $category->getName();
                }

                foreach ($product->getImagesArray() as $k => $image) {
                    $fotocnt ++;
                    // Если нету файла на диске, то идем дальше
                    if (!file_exists(PackageLoader::Get()->getProjectPath() . '/media/shop/' . $image)) {
                        continue;
                    }
                    $fotofile ++;
                }
                $productArray[] = array (
                    'productname' => $product->getName(false),
                    'productid' => $product->getId(),
                    'categoryname' => $categoryname,
                    'categoryid' => $product->getCategoryid(),
                    'articul' => $product->getCode1c(),
                    'subarticul' =>  $product->getSubarticul(),
                    'invnom' => $product->getInventarnumber(), 
                    'fotocnt' => $fotocnt,
                    'fotofile' => $fotofile,
                    'avail' => $product->getAvail(),
                );
            }
            if (-1 == $categoryID) {
                $namecurrentcategory = 'Все';
            } else {
                $namecurrentcategory = Shop::Get()->getShopService()->getCategoryByID($categoryID)->getName();
            }
            
        }
        $this->setValue('productArray', $productArray);
        $this->setValue('datereport', $datereport);
        $this->setValue('namecurrentcategory', $namecurrentcategory);

        // категории
        $this->setValue('categoryArray', $this->_makeCategoryArray());
    }

    private function _makeCategoryArray() {
        // строим массив всех категорий
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $a = array();
        while ($x = $category->getNext()) {
            $a[$x->getParentid()][] = array(
            'id' => $x->getId(),
            'name' => $x->getName(),
            'selected' => $x->getId() == $this->getArgumentSecure('categoryid'),
            'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $x->getId())),
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
            for ($j = 0; $j < $level; $j++) {
                $x['name'] = '&nbsp;&nbsp;&nbsp;'.$x['name'];
            }
            $a[] = $x;
            $childs = $this->_makeCategoryTree($x['id'], $level + 1, $categoryArray);
            foreach ($childs as $y) {
                $a[] = $y;
            }
        }
        return $a;
    }

}