<?php
class issue_ajax_get extends Engine_Class {

    public function process() {
        $result = array();

        try {
            $cuser = $this->getUser();

            $issue = IssueService::Get()->getIssueByID(
            $this->getArgumentSecure('id')
            );

            $result = array(
            'id' => $issue->getId(),
            'name' => $issue->getName(),
            'comments' => $issue->getComments(),
            'managerid' => $issue->getManagerid(),
            'categoryid' => $issue->getCategoryid(),
            'statusid' => $issue->getStatusid(),
            'statusname' => $issue->getStatus()->getName()
            );

            try {
                $category = $issue->getCategory();
                $statuses = $category->getStatuses();
                
                $statusArray = array();
                while ($status = $statuses->getNext()) {
                    $statusArray[] = array(
                    'id' => $status->getId(),
                    'text' => $status->getName()
                    );
                }
                
                $result['statusArray'] = $statusArray;
            } catch (ServiceUtils_Exception $se) {

            }

            $status = 'success';
        } catch (Exception $e) {
            print $e;
            $status = 'error';
        }

        $json = array(
        'status' => $status,
        'result' => $result
        );

        echo json_encode($json);
        exit();
    }
}