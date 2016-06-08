<?php
class funnel_chart_index extends Engine_Class {

    /**
     * @return ShopOrder
     */
    private function _getIssues() {
        return $this->getValue('issue');
    }

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/highcharts.min.js');
        PackageLoader::Get()->registerJSFile('/_js/funnel.js');

        $issues = $this->_getIssues();
        $issues->setLimit(0, 0);
        $issues->unsetField('dateclosed');

        // все изменения статусов
        $changeArray = array();
        while ($issue = $issues->getNext()) {
            $changes = new XShopOrderChange();
            $changes->setKey('statusid');
            $changes->setGroupByQuery('value');
            $changes->setOrderid($issue->getId());
            while ($x = $changes->getNext()) {
                if ($x->getValue()) {
                    $changeArray[$x->getValue()] = @$changeArray[$x->getValue()]+1;
                }
            }
        }

        // привязываем статусы к процессам
        $workflowArray = array();
        foreach ($changeArray as $key => $change) {
            try{
                $status = Shop::Get()->getShopService()->getStatusByID($key);
                $statuses = $status->getWorkflow()->getStatuses();
                while ($s = $statuses->getNext()) {
                    if (!isset($workflowArray[$s->getCategoryid()][$s->getName()])) {
                        $workflowArray[$s->getCategoryid()][$s->getName()] = array();
                    }
                }

                $workflowArray [$status->getCategoryid()][$status->getName()] = array(
                    'name' => $status->getName(),
                    'count' => $change,
                    'id' => $status->getId()

                );
                // прописываем имена процессов
                if (!isset($workflowArray[$status->getCategoryid()]['name'])) {
                    $workflowArray[$status->getCategoryid()]['name'] = Shop::Get()->getShopService()->getOrderCategoryByID($status->getCategoryid())->getName();
                }
            } catch (Exception $e) {

            }

        }

        // прописываем json
        foreach ($workflowArray as $key => $w) {
            $workflowArray[$key]['json'] = json_encode($w);
        }

        $this->setValue('workflowArray', $workflowArray);
    }

}