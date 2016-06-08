<?php
class gantt_update_parent extends Engine_Class {

    public function process() {
        try {
            $issue = IssueService::Get()->getIssueByID(
            $this->getArgument('id')
            );

            $cuser = $this->getUser();

            $parentID = $this->getArgument('parentid');

            if ($parentID) {
                try {
                    $parent = Shop::Get()->getShopService()->getOrderByID(
                    $parentID
                    );
                } catch (ServiceUtils_Exception $se) {
                    $parentID = false;
                }
            }

            IssueService::Get()->updateIssueParent(
            $cuser,
            $issue,
            $parentID
            );
        } catch (Exception $ge) {

        }
    }

}