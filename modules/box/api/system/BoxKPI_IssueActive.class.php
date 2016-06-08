<?php
/**
 * KPI processor
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxKPI_IssueActive {

    public function process(User $user, $workflowID = false) {
        $issues = IssueService::Get()->getIssuesAll();
        $issues->setManagerid($user->getId());
        $issues->setDateclosed('0000-00-00 00:00:00');
        if ($workflowID) {
            $issues->setCategoryid($workflowID);
        }
        return $issues->getCount();
    }

}