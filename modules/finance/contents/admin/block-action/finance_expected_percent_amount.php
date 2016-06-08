<?php
class finance_expected_percent_amount extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = (Array) json_decode($this->getValue('data'));
        $this->setValue('percent', $data['percent']);
    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'percent' => $this->getArgumentSecure($index.'_percent')
        );

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($data)
        );
    }

    public function processStatus(Events_Event $event) {
        $order = $this->_getOrder($event);

        $data = (Array) json_decode($this->getValue('data'));
        $data = $data['percent'];

        $percent = $data/100;
        $pdate = DateTime_Object::Now()->addDay(5)->setFormat('Y-m-d');
        $sum = $order->getSum();
        $amount = $sum * $percent;

        $probation = new XFinanceProbation();
        $probation->setAmount($amount);
        $probation->setAmountbase($order->getSum());
        $probation->setCurrencyid($order->getCurrencyid());
        $probation->setPdate($pdate);
        $probation->setCdate(DateTime_Object::Now());
        $probation->setManagerid($this->getUser()->getId());
        $probation->setOrderid($order->getId());
        $probation->insert();
    }

    /**
     * Обертка
     *
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
    }

    /**
     * Обертка
     *
     * @param Shop_Event_Order $event
     *
     * @return ShopOrder
     */
    private function _getOrder($event) {
        return $event->getOrder();
    }
}