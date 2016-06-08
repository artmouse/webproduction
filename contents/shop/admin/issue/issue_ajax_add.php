<?php
class issue_ajax_add extends Engine_Class {

    public function process() {
        try {
            // если не указано "Выполнить до", то берем дату на которую создавали
            $dateto = $this->getArgumentSecure('dateto');
            if (!$dateto || $dateto == '0000-00-00 00:00:00') {
                $dateto = $this->getArgumentSecure('date');
            }
            // создаем задачу
            $issue = IssueService::Get()->addIssue(
                $this->getUser(),
                $this->getArgumentSecure('name'),
                $this->getArgumentSecure('description'),
                $this->getArgumentSecure('managerid'),
                $this->getArgumentSecure('workflowid'), // workflow
                $dateto, // due date
                $this->getArgumentSecure('clientid'), // clientid
                $this->getArgumentSecure('parentid'), // parentid
                0
            );

            $fileIDArray = $this->getArgumentSecure('fileid', 'array');
            if ($fileIDArray) {
                Shop::Get()->getShopService()->addOrderComment(
                    $issue,
                    $this->getUser(),
                    '',
                    $fileIDArray
                );
            }

            $products = $this->getArgumentSecure('products');

            if ($products) {
                $products = explode(',', $products);
                foreach ($products as $productID) {
                    Shop::Get()->getShopService()->addOrderProduct(
                        $issue,
                        trim($productID)
                    );
                }

            }

            echo json_encode(
                array("id" => $issue->getId(), "name" => $issue->makeName(), "url" => $issue->makeURLEdit())
            );
            exit();
        } catch (ServiceUtils_Exception $e) {
            foreach ($e->getErrorsArray() as $ex) {
                if ($ex == 'workflow') {
                    echo json_encode(
                        array(
                            "name" => 'Невозможно создать задачу. Добавьте бизнес-процесс по умолчанию.',
                            "error" => 1
                        )
                    );
                    exit();
                }

            }
            echo json_encode(array("name" => 'Невозможно создать задачу.', "error" => 1));
            exit();

        }


    }

}