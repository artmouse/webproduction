<?php
class action_block_order_closed_by_dateto extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        if (Shop_ModuleLoader::Get()->isImported('finance')) {
            $this->setValue('module_finance', true);
        }

        $data = (Array) json_decode($this->getValue('data'));
        $this->setValue('payment', $data['payment']);

    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'payment' => (int) trim($this->getArgumentSecure($index.'_payment'))
        );

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($data)
        );
    }

    public function processCronDay(Events_Event $event) {
        $event;

        $status = $this->_getStatus();
        $data = (Array) json_decode($this->getValue('data'));

        $payment = $data['payment'];

        if ($payment && !Shop_ModuleLoader::Get()->isImported('finance')) {
            $payment = false;
        }

        $now = DateTime_Object::Now();
        // получить задачи с контролируемым этапом
        $orders = Shop::Get()->getShopService()->getOrdersAll(false, true);
        $orders->filterDateclosed('0000-00-00 00:00:00');
        $orders->filterStatusid($status->getId());
        $orders->addWhere('dateto', '0000-00-00 00:00:00', '<>');
        $orders->addWhere('dateto', $now->setFormat('Y-m-d H:i:s')->__toString(), '<=');

        while ($order = $orders->getNext()) {
            try {
                if ($payment && $order->makeSumBalance() < 0) {
                    continue;
                }
                $manager = false;
                try{
                    $manager = $order->getManagerOrAuthor();

                } catch (Exception $emanager) {

                }
                Shop::Get()->getShopService()->closeOrder($order, $manager);
            } catch (Exception $e) {

            }

        }

    }

    /**
     * Обертка
     *
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
    }

}