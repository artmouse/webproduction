<?php
class ajax_admin_create_issue extends Engine_Class {

    public function process() {
        $assigned = $this->getArgumentSecure('assigned');
        $name = $this->getArgumentSecure('name');
        $process = $this->getArgumentSecure('process');
        $content = $this->getArgumentSecure('content');

        $resultArray['status'] = 'error';
        if ( $assigned && $name && $process) {
            try {
                IssueService::Get()->addIssue(
                    $this->getUser(),
                    $name,
                    $content,
                    $assigned,
                    $process
                );
                $resultArray['status'] = 'success';
            }catch( Exception $e ) {

            }
        }
        echo json_encode($resultArray);
        exit;
    }

}