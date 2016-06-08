<?php
class issue_ajax_add extends Engine_Class {

    public function process() {
        $result = false;
        $status = false;
        $errorsArray = array();

        try {
            $cuser = $this->getUser();

            $project = IssueService::Get()->getProjectByID(
            $this->getArgument('projectid')
            );

            // находим бизнес-процесс по умолчанию
            $categoryID = $project->getCategoryid();
            if (!$categoryID) {
                $category = new ShopOrderCategory();
                $category->setDefault(1);
                $category->setType('issue');
                if ($category->select()) {
                    $categoryID = $category->getId();
                }
            }

            $issue = IssueService::Get()->addIssue(
            $cuser,
            $this->getArgumentSecure('name'),
            '',
            $project->getId(), // @todo: project'a уже нет
            false,
            $categoryID,
            false,
            false,
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