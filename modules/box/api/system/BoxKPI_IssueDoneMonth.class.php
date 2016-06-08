<?php
/**
 * KPI processor
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxKPI_IssueDoneMonth {

    public function process(User $user, $workflowID = false) {
        $cdate = date('Y-m-01').' 00:00:00';

        $issues = IssueService::Get()->getIssuesAll();
        $issues->setManagerid($user->getId());
        $issues->addWhere('dateclosed', $cdate, '>=');
        if ($workflowID) {
            $issues->setCategoryid($workflowID);
        }
        return $issues->getCount();
    }

}