<?php
class issue_ajax_update extends Engine_Class {

    public function process() {
        $result = false;
        $status = false;
        $errorsArray = array();

        try {
            $cuser = $this->getUser();

            $issue = IssueService::Get()->getIssueByID($this->getArgument('id'));
            $project = $issue->getProject();

            IssueService::Get()->updateIssueParent(
            $cuser,
            $issue,
            $this->getArgumentSecure('parentid')
            );

            // обновляем json файл
            $result = IssueService::Get()->updateIssueMindJson($project);

            $status = 'success';
        } catch (Exception $e) {
            print $e;
            $status = 'error';
            $errorsArray = array();
        }

        $json = array(
        'status' => $status,
        'result' => $result,
        'errors' => $errorsArray
        );

        echo json_encode($json);
        exit();
    }

}