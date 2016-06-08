<?php
class calendar_block_issue extends Engine_Class {

    public function process() {
        $order = $this->_getIssue();

        try {
            if ($order->getStatus()->getClosed()) {
                // для закрытых задач проверяем можно ли открыть
                $status = $order->getStatus()->getWorkflow()->getStatusDefault();
            } else {
                // для открытых задач проверяем можно ли закрыть
                $status = $order->getStatus()->getWorkflow()->getStatusClosed();
            }

            $canChange = !$status->getOnlyauto();

            // проверка, можно ли перейти в этот статус (issue #61622)
            if ($canChange && !$order->getStatus()->canChangeTo($status)) {
                $canChange = false;
            }
        } catch (Exception $statusEx) {
            $canChange = false;
        }

        $time = DateTime_Formatter::TimeISO8601($order->getDateto());
        if ($time == '00:00') {
            $time = false;
        }

        try {
            $projectName = $order->getParent()->getName();
        } catch (ServiceUtils_Exception $se) {
            $projectName = false;
        }

        $nameClear = false;
        try {
            if ($order) {
                $nameClear = $order->getName();
                if (!$nameClear) {
                    $nameClear = $order->makeName();
                }
            }

        } catch (Exception $ee) {

        }

        $infoArray = array(
        'nameClear' => $nameClear,
        'name' => $order->makeName(),
        'url' => $order->makeURLEdit(),
        'closed' => $order->isClosed(),
        'id' => $order->getId(),
        'canChange' => $canChange,
        'time' => $time,
        'project' => $order->getParentid() ? false:true,
        'isOrder' => true,
        'description' => htmlspecialchars(nl2br($order->getComments())),
        'projectName' => $projectName,
        'fireIssue' => Shop::Get()->getShopService()->isFireOrder($order)
        );

        $this->setValue('order', $infoArray);
    }

    /**
     * Получить задачу
     *
     * @return ShopOrder
     */
    private function _getIssue() {
        return $this->getValue('issue');
    }

}