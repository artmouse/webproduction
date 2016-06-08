<?php
class user_issue_block extends Engine_Class {

    public function process() {
        $userIDArray = $this->getValue('userIDArray');
        $user = $this->getValue('user');

        $issues = IssueService::Get()->getIssuesAll($this->getUser());
        $issues->setType('issue');
        $issues->addWhereQuery("(authorid={$user->getId()} OR userid={$user->getId()} OR managerid={$user->getId()})");
        $issues->setDateclosed('0000-00-00 00:00:00');
        $this->setValue('issueOpenCount', $issues->getCount());

        $issues = IssueService::Get()->getIssuesAll($this->getUser());
        $issues->setType('issue');
        $issues->addWhereQuery("(authorid={$user->getId()} OR userid={$user->getId()} OR managerid={$user->getId()})");
        $issues->addWhere('dateclosed', '0000-00-00 00:00:00', '<>');
        $this->setValue('issueClosedCount', $issues->getCount());

        $this->setValue('urlIssues', Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-users-issue', $user->getId()));
    }

}