<?php
class issue_ajax_edit extends Engine_Class {

    public function process() {
        $result = false;
        $status = false;
        $errorsArray = array();

        try {
            $cuser = $this->getUser();
            $issue = IssueService::Get()->getIssueByID($this->getArgument('id'));
            $project = $issue->getProject();

            try {
                SQLObject::TransactionStart();

                $issue->setName($this->getControlValue('name'));
                $issue->setComments($this->getControlValue('comments'));
                $issue->update();

                // обновляем менеджера заказа
                try {
                    $manager = Shop::Get()->getUserService()->getUserByID(
                    $this->getControlValue('managerid')
                    );

                    Shop::Get()->getShopService()->updateOrderManager($issue, $this->getUser(), $manager);
                } catch (Exception $e) {
                    // убираем менеджера заказа
                    Shop::Get()->getShopService()->updateOrderManager($issue, $this->getUser(), 0);
                }

                // обновляем категорию
                try {
                    $category = Shop::Get()->getShopService()->getOrderCategoryByID(
                    $this->getControlValue('categoryid')
                    );

                    $issue->setCategoryid($category->getId());
                    $issue->setOutcoming($category->getOutcoming());

                    // обновляем срок
                    if ($category->getTerm() > 0) {
                        $issue->setDateto(DateTime_Object::FromString($issue->getCdate())->addDay((int) $category->getTerm())->__toString());
                    }
                } catch (Exception $e) {
                }

                $issue->update();

                // обновляем статус
                if ($this->getControlValue('statusid')) {
                    Shop::Get()->getShopService()->updateOrderStatus(
                    $cuser,
                    $issue,
                    $this->getControlValue('statusid')
                    );
                }

                SQLObject::TransactionCommit();
            } catch (Exception $ge) {
                SQLObject::TransactionRollback();
            }

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

    private function _makeIssueTree($parentID, $level, $issueArray, $nodeID) {
        $a = array();

        if (empty($issueArray[$parentID])) {
            $result = array();
            $result['data'] = $a;
            $result['nodeid'] = $nodeID;
            return $result;
        }

        foreach ($issueArray[$parentID] as $x) {
            $nodeID++;
            $x['nodeid'] = $nodeID;

            $result = $this->_makeIssueTree($x['issueid'], $level + 1, $issueArray, $nodeID);
            $childs = $result['data'];
            $nodeID = $result['nodeid'];

            $b = array();
            foreach ($childs as $y) {
                $b[] = $y;
            }

            $x['children'] = $b;

            $a[] = $x;
        }

        $result = array();
        $result['data'] = $a;
        $result['nodeid'] = $nodeID;
        return $result;
    }


}