<?php
class issue_index extends Engine_Class {

    public function process() {
        $issues = IssueService::Get()->getIssuesAll($this->getUser());

        $list = Engine::GetContentDriver()->getContent('issue-list');
        $list->setValue('issues', $issues);
        $this->setValue('block_issue', $list->render());
    }

}