<?php
class funnel_index extends Engine_Class {

    /**
     * @return ShopOrder
     */
    private function _getIssues() {
        return $this->getValue('issue');
    }

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/jsPlumb.js');

        $issues = $this->_getIssues();
        $issues->setLimit(0, 0);
        $issues->unsetField('dateclosed');

        // все категории, в которых состоят задачи
        $workflowArray = array();
        while ($issue = $issues->getNext()) {
            try {
                $category = $issue->getCategory();
                $issueStatus = $issue->getStatus();

                if (isset($workflowArray[$category->getId()])) {
                    $workflowArray[$category->getId()]['statusArray'][$issueStatus->getId()]['issueCount']++;
                    continue;
                }

                // статусы на основе категории
                $statusArray = array();

                $position_y_max = 0;

                $status = $category->getStatuses();
                while ($s = $status->getNext()) {
                    $statusArray[$s->getId()] = array(
                    'id' => $s->getId(),
                    'name' => $s->getName(),
                    'colour' => $s->getColour(),
                    'positionx' => $s->getX(),
                    'positiony' => $s->getY(),
                    'width' => $s->getWidth(),
                    'height' => $s->getHeight() + 15, // поправка на полоску с иконками
                    'statusAllow' => !$s->getOnlyauto(),
                    'issueCount' => ($issueStatus->getId() == $s->getId())?1:0
                    );

                    // максимальная высота workflow'a
                    if ($position_y_max < $s->getY() + $s->getHeight()) {
                        $position_y_max = $s->getY() + $s->getHeight();
                    }
                }

                if ($position_y_max > 0) {
                    $position_y_max += 50;
                }
                $this->setValue('position_y_max', $position_y_max);

                $changeArray = array();
                $changes = new XShopOrderStatusChange();
                $changes->setCategoryid($category->getId());
                while ($x = $changes->getNext()) {
                    if ($x->getElementfromid() == $x->getElementtoid()) {
                        continue;
                    }
                    $changeArray[$x->getElementfromid()][$x->getElementtoid()] = 1;
                }

                $workflowArray[$category->getId()] = array(
                'name' => $category->makeName(),
                'statusArray' => $statusArray,
                'changeArray' => $changeArray
                );

            } catch (Exception $wfEx) {

            }
        }

        $this->setValue('workflowArray', $workflowArray);
        $this->setValue('url', Engine_URLParser::Get()->getMatchURL());
    }

}