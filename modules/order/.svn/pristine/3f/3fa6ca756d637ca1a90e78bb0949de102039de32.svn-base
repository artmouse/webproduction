<?php
class report_topproducts extends Engine_Class {

    public function process() {
        $dateFrom = $this->getArgumentSecure('datefrom');
        $dateTo = $this->getArgumentSecure('dateto');

        if (!$dateFrom) {
            $dateFrom = DateTime_Object::Now()->addDay(+0)->setFormat('Y-m-01')->__toString();

            $this->setControlValue('datefrom', $dateFrom);
        } else {
            $dateFrom = DateTime_Object::FromString($dateFrom)->setFormat('Y-m-d')->__toString();
        }
        if (!$dateTo) {
            $dateTo = DateTime_Object::Now()->addMonth(+1)->setFormat('Y-m-t')->__toString();

            $this->setControlValue('dateto', $dateTo);
        } else {
            $dateTo = DateTime_Object::FromString($dateTo)->setFormat('Y-m-d')->__toString();
        }

        $categoryID = $this->getArgumentSecure('categoryid', 'int');
        $brandID = $this->getArgumentSecure('brandid', 'int');
        $sourceID = $this->getArgumentSecure('sourceid', 'int');
        $managerID = $this->getArgumentSecure('managerid', 'int');
        $authorID = $this->getArgumentSecure('authorid', 'int');
        $contractorID = $this->getArgumentSecure('contractorid', 'int');

        $workflowIDArray = $this->getArgumentSecure('workflowid', 'array');
        $statusIDArray = $this->getArgumentSecure('statusid', 'array');

        // -------

        // идем по всем заказам и считаем статистику

        $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
        $orders->addWhere('cdate', $dateFrom, '>=');
        $orders->addWhere('cdate', $dateTo.' 23:59:59', '<=');
        if ($sourceID) {
            $orders->setSourceid($sourceID);
        }
        if ($managerID) {
            $orders->setManagerid($managerID);
        }
        if ($authorID) {
            $orders->setAuthorid($authorID);
        }
        if ($contractorID) {
            $orders->setContractorid($contractorID);
        }
        if ($workflowIDArray) {
            $orders->addWhereArray($workflowIDArray, 'categoryid');
        }
        if ($statusIDArray) {
            $orders->addWhereArray($statusIDArray, 'statusid');
        }

        $reportCountArray = array();
        $reportSumArray = array();
        $productArray = array();

        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
        $this->setValue('currency', $currencyDefault->getName());

        while ($order = $orders->getNext()) {
            $ops = $order->getOrderProducts();
            while ($op = $ops->getNext()) {
                try {
                    if ($brandID && $brandID != $op->getProduct()->getBrandid()) {
                        continue;
                    }
                } catch (Exception $e) {

                }

                try {
                    if ($categoryID && $categoryID != $op->getProduct()->getCategoryid()) {
                        continue;
                    }
                } catch (Exception $e) {

                }

                try {
                    $productArray[$op->getProductid()] = array(
                        'name' => $this->_escapeString($op->getProduct()->makeName()),
                        'url' => $op->getProduct()->makeURLEdit(),
                    );
                } catch (Exception $e) {

                }

                $price = Shop::Get()->getCurrencyService()->convertCurrency(
                    $op->getProductprice(),
                    $op->getCurrency(),
                    $currencyDefault
                );

                @$reportCountArray[$op->getProductid()] += $op->getProductcount();
                @$reportSumArray[$op->getProductid()] += round(
                    $price * $op->getProductcount(),
                    2
                );
            }
        }

        // подсчет среднего чека
        $reportAvgArray = array();
        foreach ($reportSumArray as $productID => $sum) {
            $reportAvgArray[$productID] = round($sum / $reportCountArray[$productID], 2);
        }

        $this->setValue('reportCountArray', $reportCountArray);
        $this->setValue('reportSumArray', $reportSumArray);
        $this->setValue('reportAvgArray', $reportAvgArray);
        $this->setValue('productArray', $productArray);

        // -------

        // категории
        $this->setValue('categoryArray', $this->_makeCategoryArray());

        // менеджеры
        $a = array();
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            );
        }
        $this->setValue('managerArray', $a);

        // источники заказов
        $sources = Shop::Get()->getShopService()->getSourceAll();
        $this->setValue('sourceArray', $sources->toArray());

        // юридические лица
        $contractors = Shop::Get()->getShopService()->getContractorsActive();
        $this->setValue('contractorArray', $contractors->toArray());

        // бренды
        $brands = Shop::Get()->getShopService()->getBrandsAll();
        $this->setValue('brandArray', $brands->toArray());

        // статусы заказов
        $block = Engine::GetContentDriver()->getContent('workflow-filter-block');
        $this->setValue('block_workflow_filter', $block->render());
    }

    /**
     * Построить дерево категорий
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

    private function _escapeString($s) {
        $s = trim($s);
        $s = str_replace("\n", '', $s);
        $s = str_replace("\r", '', $s);
        $s = str_replace("\t", '', $s);
        $s = str_replace("'", '', $s);
        $s = str_replace("\"", '', $s);
        return $s;
    }

    private function _getOrderStatus() {
        $orderStatus = Shop::Get()->getShopService()->getStatusAll();
        $status = array();
        while ($x = $orderStatus->getNext()) {
            try {
                $category = Shop::Get()->getShopService()->getOrderCategoryByID(
                    $x->getCategoryid()
                );

                $categoryName = $category->makeName();
            } catch (Exception $e) {
                $categoryName = Shop::Get()->getTranslateService()->getTranslateSecure('translate_no_category');
            }

            $status[$categoryName][] = array(
            'id' => $x->getId(),
            'name' => $x->getName(),
            'color' => $x->getColour(),
            );
        }
        return $status;
    }

}