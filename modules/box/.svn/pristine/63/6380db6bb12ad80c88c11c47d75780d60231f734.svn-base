<?php
/**
 * KPI processor
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxKPI_IssueHot {

    public function process(User $user, $workflowID = false) {
        $issues = IssueService::Get()->getIssuesAll();
        $issues->setManagerid($user->getId());
        $issues->setDateclosed('0000-00-00 00:00:00');
        $issues->addWhere('dateto', date('Y-m-d H:i:s'), '<=');
        if ($workflowID) {
            $issues->setCategoryid($workflowID);
        }
        return $issues->getCount();
    }

}