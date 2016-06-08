<?php
/**
 * KPI processor
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxKPI_IssueActiveDay {

    public function process(User $user, $workflowID = false) {
        $cdate = date('Y-m-d');

        $issues = IssueService::Get()->getIssuesAll();
        $issues->setManagerid($user->getId());
        $issues->setDateclosed('0000-00-00 00:00:00');
        $issues->addWhere('dateto', $cdate.' 00:00:00', '>=');
        $issues->addWhere('dateto', $cdate.' 23:59:59', '<=');
        if ($workflowID) {
            $issues->setCategoryid($workflowID);
        }
        return $issues->getCount();
    }

}