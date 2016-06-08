<?php
class calendar_issue_update extends Engine_Class {

    public function process() {
        try {
            $issue = IssueService::Get()->getIssueByID(
                $this->getArgument('id')
            );

            $employerId = $this->getArgumentSecure('employerId');

            // открыть или закыть задачу
            try {
                $status = $this->getArgument('status', 'bool');

                if ($status) {
                    // закрыть задачу
                    $status = $issue->getWorkflow()->getStatusClosed();
                } else {
                    // открыть задачу
                    $status = $issue->getWorkflow()->getStatusDefault();
                }

                // обновляем задачу
                Shop::Get()->getShopService()->updateOrderStatus(
                    $this->getUser(),
                    $issue,
                    $status->getId()
                );
            } catch (Exception $e) {

            }

            // переместить задачу на другую дату
            // перемещается due date
            try {
                $date = $this->getArgument('date');
                $time = DateTime_Object::FromString($issue->getDateto())->setFormat('H:i:s')->__toString();
                $date = DateTime_Formatter::DateISO9075($date).' '.$time;

                /*if ($employerId) {
                    $employer = new XShopOrderEmployer($employerId);
                    $employer->setTerm($date);
                    $employer->update();
                } else {*/
                IssueService::Get()->updateIssueDateto($issue, $this->getUser(), $date);
                //}

            } catch (Exception $e) {

            }

            // переместить задачу на другое время
            // перемещается due date
            try {
                $time = $this->getArgument('time');
                $date = DateTime_Formatter::DateISO9075($issue->getDateto()).' '.$time;

                /*if ($employerId) {
                    $employer = new XShopOrderEmployer($employerId);
                    $employer->setTerm($date);
                    $employer->update();
                } else {*/
                $issue->setDateto($date);
                $issue->update();
                //}
            } catch (Exception $e) {

            }

            $idArray = false;
            $priorityArray = false;

            try {
                $priorityArray = $this->getArgument('priorityArray', 'array');
                $idArray = $this->getArgument('idArray', 'array');
            } catch (Exception $e) {
            }

            if ($idArray && $priorityArray) {
                try {
                    SQLObject::TransactionStart();

                    foreach ($idArray as $k => $id) {
                        try {
                            $order = Shop::Get()->getShopService()->getOrderByID($id);

                            $order->setPriority($priorityArray[$k]);
                            $order->update();
                        } catch (ServiceUtils_Exception $oe) {

                        }
                    }

                    SQLObject::TransactionCommit();
                } catch (Exception $e) {
                    SQLObject::TransactionRollback();
                }
            }
        } catch (Exception $ge) {

        }
    }

}