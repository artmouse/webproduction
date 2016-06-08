<?php
class orders_control_block_workflow extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/jsPlumb.js');

        try {
            // получаем заказ
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            $this->setValue('orderid', $order->getId());
            $this->setValue('status_id', $order->getStatusid());

            // статусы заказа по workflow
            $statusNextArray = array();
            try {
                $category = $order->getWorkflow();

                $statuses = WorkflowService::Get()->getStatusNextByWorkflow($category, $order->getStatus());
                while ($s = $statuses->getNext()) {
                    $statusNextArray[] = array(
                       'id' => $s->getId(),
                       'name' => $s->makeName(),
                    );
                }
            } catch (Exception $e) {

            }
            $this->setValue('statusNextArray', $statusNextArray);

            // статусы заказа
            $statusArray = array();
            try {
                // статусы на основе категории
                $category = $order->getCategory();

                $position_y_max = 0;

                $status = $category->getStatuses();
                while ($s = $status->getNext()) {
                    // есть ли открытые задачи?
                    $subIssue = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
                    $subIssue->setParentid($order->getId());
                    $subIssue->setParentstatusid($s->getId());

                    $allClosed = true;
                    $subIssueCount = 0;
                    while ($sub = $subIssue->getNext()) {
                        $subIssueCount++;
                        if ($sub->getDateclosed() == '0000-00-00 00:00:00') {
                            $allClosed = false;
                            break;
                        }
                    }

                    // горит ли задача?
                    $fire = Shop::Get()->getShopService()->isFireOrderStatus($order, $s);

                    $statusArray[] = array(
                    'id' => $s->getId(),
                    'name' => $s->getName(),
                    'colour' => $s->getColour(),
                    'positionx' => $s->getX(),
                    'positiony' => $s->getY(),
                    'width' => $s->getWidth(),
                    'height' => $s->getHeight(),
                    'statusAllow' => !$s->getOnlyauto(),
                    'allClosed' => $subIssueCount ? $allClosed:false,
                    'fireIssue' => $fire,
                    'next' => array_key_exists($s->getId(), $statusNextArray)
                    );

                    // максимальная высота workflow'a
                    if ($position_y_max < $s->getY() + $s->getHeight()) {
                        $position_y_max = $s->getY() + $s->getHeight();
                    }
                }

                if ($position_y_max > 0) {
                    $position_y_max += 50;
                }
                $this->setValue('position_y_max', $position_y_max);

                $changeArray = array();
                $changes = new XShopOrderStatusChange();
                $changes->setCategoryid($category->getId());
                while ($x = $changes->getNext()) {
                    if ($x->getElementfromid() == $x->getElementtoid()) {
                        continue;
                    }
                    $changeArray[$x->getElementfromid()][$x->getElementtoid()] = 1;
                }
                $this->setValue('changeArray', $changeArray);

            } catch (Exception $wfEx) {
                // статусы списком
                $status = Shop::Get()->getShopService()->getStatusAll();
                while ($s = $status->getNext()) {
                    $statusArray[] = array(
                    'id' => $s->getId(),
                    'name' => $s->getName(),
                    );
                }
            }
            $this->setValue('statusArray', $statusArray);

        } catch (Exception $ge) {

        }
    }
}