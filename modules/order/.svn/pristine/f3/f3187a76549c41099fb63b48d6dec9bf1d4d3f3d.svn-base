<?php
class report_priceinsupplier extends Engine_Class {

    public function process() {
        try {
            $cat = Shop::Get()->getShopService()->getCategoryAll();
            $cat->setOrder('id');
            $c = $cat->getNext();
            if ($c) {
                if (!$this->getControlValue('categoryid')) {
                    $this->setControlValue('categoryid', $c->getId());
                }
            }
            
            $categoryID = $this->getControlValue('categoryid');            
            $brandid = $this->getControlValue('brandid');
            $filtersupplierid = $this->getControlValue('supplierid');
            $filtermodel = $this->getControlValue('modelname');

            $products = Shop::Get()->getShopService()->getProductsAll();
            if ($categoryID) {
                $products->addWhereQuery(
                    '(`category1id` = '.$categoryID.
                    ' OR `category2id` = '.$categoryID.
                    ' OR `category3id` = '.$categoryID.
                    ' OR `category4id` = '.$categoryID.
                    ' OR `category5id` = '.$categoryID.')'
                );
                //$products->setCategoryid($categoryID);
            }
            if ($brandid) {
                $products->setBrandid($brandid);
            }   
            
            if ($filtermodel) {
                $products->setModel($filtermodel);
            }
            
            $products->setDeleted(0);
            
            $productArray = array();
            $supplierName = array();
            $products->setLimit($this->getArgumentSecure('page') * 500, 500);
            while ($product = $products->getNext()) {
                $x = array();
                $x['id'] = $product->getId();
                $x['name'] = $product->getName();
                $x['price'] = $product->getPrice();
                $x['articul'] = $product->getArticul();
                $x['url'] = $product->makeUrl();
                $flag = false;
                
                
                $productSupplier = Shop::Get()->getSupplierService()->getProductSupplierFromProduct($product);
                while ($p = $productSupplier->getNext()) {
                    $supplierId = $p->getSupplierid();
                    if ($filtersupplierid && ($filtersupplierid != $supplierId)) {
                        continue;
                    }
                    if ($supplierId) {
                        try {
                            $supplier = Shop::Get()->getSupplierService()->getSupplierByID($supplierId);
                            $x[$supplier->getName()] = $p->getPrice();
                            $supplierName[$supplier->getId()] = $supplier->getName();
                            $flag = true;
                        } catch (Exception $ex) {
                            
                        }
                    }
                }
                
                if ($flag) {
                    $productArray[] = $x; 
                }
                
            }
            $this->setValue('productArray', $productArray);
            $this->setValue('supplierName', $supplierName);
            
            // категории
            $categories = Shop::Get()->getShopService()->getCategoryAll();
            $this->setValue('categoryArray', $categories->toArray());
            // бренды
            $brands = Shop::Get()->getShopService()->getBrandsAll();
            $this->setValue('brandArray', $brands->toArray());
            
            // supplier
            $suppliers = Shop::Get()->getSupplierService()->getSuppliersAll();
            $this->setValue('supplierArray', $suppliers->toArray());
            
            /*$model = Shop::Get()->getShopService()->getProductsAll();
            $model->filterModel('', '!=');
            $model->setGroupByQuery('model');
            $modelArray = array();
            while ($m = $model->getNext()) {
                $modelArray[] = $m->getModel();
            }
            $this->setValue('modelArray', $modelArray);*/
            
            $onpage = 500;
            $page = Engine::GetURLParser()->getArgumentSecure('page');
            $this->setValue('pagesArray', $this->_pages($page, $onpage, $products->getCount()));

            $products->setLimitCount($onpage);
            $products->setLimitFrom($page * $onpage);
            
            $this->setValue('urlget', Engine::GetURLParser()->getGETString());
            
            if ($this->getArgumentSecure('export-xls')) {
                $dataArray = false;              
                foreach ($productArray as $item => $prod) {
                    $x = array();
                    $x['id'] = $prod['id'];
                    $x['articul'] = $prod['articul'];
                    $x['name'] = $prod['name'];
                    
                    foreach ($supplierName as $supname) {
                        if (@$prod[$supname]) {
                            @$x[$supname] = @$prod[$supname];
                        } else {
                            @$x[$supname] = 0;
                        }
                    }
                    $dataArray[] = $x;
                }
                $filename = 'export '.date('Y-m-d H:i:s').' pricesupplier';
                PackageLoader::Get()->import('XLS');
                $xls = XLS_Creator::CreateFromArray($dataArray);
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment; filename="'.$filename.'.xls"');
                print $xls->__toString();
                exit();
            }
            
            
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }

    }
    
    private function _pages($page, $onPage, $count) {
        $assignsArray = array();

        $a = array();
        $cnt = ceil($count / $onPage);

        $stop = $page + 3;
        $start = $page - 3;

        if ($stop > $cnt) {
            $stop = $cnt;
            $start = $stop - 5;
        }

        if ($start < 0) {
            $start = 0;
            $stop = $start + 5;
        }
        if ($stop > $cnt) {
            $stop = $cnt;
        }

        for ($j = $start; $j < $stop; $j++) {
            $a[] = array(
                'name' => ($j + 1),
                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('page' => $j)),
                'selected' => $j == $page,
            );
        }

        $assignsArray['pagesArray'] = $a;

        // текущая страница
        $assignsArray['pageCurrent'] = $page;

        if ($page + 1 < $cnt) {
            $assignsArray['urlnext'] = Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(
                array('page' => $page + 1)
            );
        }

        if ($page - 1 >= 0) {
            $assignsArray['urlprev'] = Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(
                array('page' => $page - 1)
            );
        }

        if ($stop - $start > 0) {
            $assignsArray['hellip'] = true;
        }

        return $assignsArray;
    }

}