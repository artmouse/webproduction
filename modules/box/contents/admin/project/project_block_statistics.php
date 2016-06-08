<?php
class project_block_statistics extends Engine_Class {

    public function process() {
        $project = $this->_getProject();

        // посчитать сколько открытых / закрытых задач в проекте
        $countArray = $this->_makeIssueCountArray(
            $project->getId(),
            array(
                'open' => 0,
                'closed' => 0
            )
        );

        $issueOpenCount = $countArray['open'];
        $issueClosedCount = $countArray['closed'];

        $this->setValue('issueOpenCount', $issueOpenCount);
        $this->setValue('issueClosedCount', $issueClosedCount);

        if ($issueOpenCount || $issueClosedCount) {
            // процент выполнения
            $this->setValue(
                'percentDone',
                round(100 * $issueClosedCount / ($issueOpenCount + $issueClosedCount))
            );

            // за последние 2 месяца по дням: сколько открыто / закрыто задач
            $dateTo = date('Y-m-d');
            $dateFrom = DateTime_Object::FromString($dateTo)->addMonth(-2)->setFormat('Y-m-d')->__toString();
            $periodArray = array();
            while ($dateFrom <= $dateTo) {
                $periodKey = DateTime_Object::FromString($dateFrom)->setFormat('d.m')->__toString();

                $periodArray[$periodKey] = $this->_makeIssueCountArrayByDate(
                    $project->getId(),
                    $dateFrom,
                    array(
                        'open' => 0,
                        'closed' => 0
                    )
                );

                $dateFrom = DateTime_Object::FromString($dateFrom)->addDay(1)->setFormat('Y-m-d')->__toString();
            }

            $this->setValue('periodArray', $periodArray);
        }
    }

    /**
     * Посчитать сколько открытых / закрытых задач в проекте
     *
     * @param int $parentID
     * @param array $resultArray
     *
     * @return array
     */
    private function _makeIssueCountArray($parentID, $resultArray, $subIssues = false) {
        if (!$subIssues) {
            $subIssues = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
        }
        $subIssuesRecursive = clone $subIssues;

        $subIssues->setParentid($parentID);
        $subIssues->setOrder('id', 'ASC');

        while ($sub = $subIssues->getNext()) {
            if ($sub->getId() != $parentID) {

                if ($sub->getDateclosed() == '0000-00-00 00:00:00') {
                    $resultArray['open']++;
                } else {
                    $resultArray['closed']++;
                }

                $resultArray = $this->_makeIssueCountArray($sub->getId(), $resultArray, $subIssuesRecursive);
            }
        }

        return $resultArray;
    }

    /**
     * Посчитать сколько задач было открыто / закрыто в проекте в указанную дату
     *
     * @param int $parentID
     * @param string $date
     * @param array $resultArray
     *
     * @return array
     */
    private function _makeIssueCountArrayByDate($parentID, $date, $resultArray) {
        $subIssues = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
        $subIssues->setParentid($parentID);
        $subIssues->setOrder('id', 'ASC');

        if ($date) {
            $subIssues->addWhereQuery("(cdate >= '{$date}' OR dateclosed >= '{$date}')");
        }

        while ($sub = $subIssues->getNext()) {
            if ($sub->getId() != $parentID) {
                $cdate = DateTime_Object::FromString($sub->getCdate())->setFormat('Y-m-d')->__toString();
                $dateclosed = DateTime_Object::FromString($sub->getDateclosed())->setFormat('Y-m-d')->__toString();

                if ($cdate == $date) {
                    $resultArray['open']++;
                }

                if ($dateclosed == $date) {
                    $resultArray['closed']++;
                }
                //$resultArray = $this->_makeIssueCountArrayByDate($sub->getId(), $date, $resultArray);
            }
        }

        return $resultArray;
    }

    /**
     * Получить проект
     *
     * @return ShopOrder
     */
    private function _getProject() {
        return $this->getValue('project');
    }

}