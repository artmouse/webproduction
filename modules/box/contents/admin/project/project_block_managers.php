<?php
class project_block_managers extends Engine_Class {

    public function process() {
        $project = $this->_getProject();

        // посчитать количество задач по менеджерам
        $issueCountArray = $this->_makeIssueCountArrayByManager(
            $project->getId(),
            array(
                'all' => array(
                    'closed' => 0,
                    'total' => 0
                )
            )
        );

        // всего закрытых задач в проекте
        $issueCountClosed = $issueCountArray['all']['closed'];
        // всего задач в проекте
        $issueCountTotal = $issueCountArray['all']['total'];

        $a = array();
        foreach ($issueCountArray as $managerID => $issueCount) {
            $b = array();
            try {
                $user = Shop::Get()->getUserService()->getUserByID($managerID);

                $b['userName'] = $user->makeName(true, 'lfm');

                $b['issueCount'] = $issueCount['total'];
                $b['issueCountClosed'] = $issueCount['closed'];

                // процент количества задач назначенных на данного менеджера от общего количества в проекте

                $b['percentAll'] = 0;
                if ($issueCountTotal) {
                    $b['percentAll'] = round($issueCount['total'] * 100 / $issueCountTotal);
                }

                $b['percentDone'] = 0;
                if ($issueCountClosed) {
                    $b['percentDone'] = round($issueCount['closed'] * 100 / $issueCountClosed);
                }

                $a[] = $b;
            } catch (ServiceUtils_Exception $se) {

            }
        }

        $this->setValue('managerArray', $a);
    }

    private function _makeIssueCountArrayByManager($parentID, $resultArray, $subIssues = false) {
        if (!$subIssues) {
            $subIssues = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
        }

        $subIssueRecursive = clone $subIssues;

        $subIssues->setParentid($parentID);
        $subIssues->setOrder('id', 'ASC');

        while ($sub = $subIssues->getNext()) {
            if ($sub->getId() != $parentID) {
                if (!isset($resultArray[$sub->getManagerid()])) {
                    $resultArray[$sub->getManagerid()] = array(
                        'closed' => 0,
                        'total' => 0
                    );
                }

                if ($sub->getDateclosed() != '0000-00-00 00:00:00') {
                    $resultArray[$sub->getManagerid()]['closed']++;
                    $resultArray['all']['closed']++;
                }

                $resultArray[$sub->getManagerid()]['total']++;
                $resultArray['all']['total']++;

                $resultArray = $this->_makeIssueCountArrayByManager($sub->getId(), $resultArray, $subIssueRecursive);
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