<?php
class action_block_order_copy extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = (Array) json_decode($this->getValue('data'));
        $this->setValue('time', $data['time']);
        $this->setValue('products', $data['products']);

    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'time' => (int) trim($this->getArgumentSecure($index.'_time')),
            'products' => $this->getArgumentSecure($index.'_products')
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
        $days = (int) $data['time'];

        $dateto = DateTime_Object::Now()->addDay($days)->setFormat('Y-m-d H:i:s');

        $now = DateTime_Object::Now();
        // получить задачи с контролируемым этапом
        $orders = Shop::Get()->getShopService()->getOrdersAll(false, true);
        $orders->filterDateclosed('0000-00-00 00:00:00');
        $orders->filterStatusid($status->getId());
        $orders->setNextid(0);
        $orders->addWhere('dateto', '0000-00-00 00:00:00', '<>');
        $orders->addWhere('dateto', $dateto, '<=');

        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();
        while ($order = $orders->getNext()) {
            try {
                $cloneOrder = Shop::Get()->getShopService()->cloneOrder($order);
                if ($cloneOrder) {
                    $cloneOrder->setPrevid($order->getId());
                    $cloneOrder->setCdate(
                        DateTime_Object::FromString($order->getDateto())->addDay(1)->setFormat('Y-m-d H:i:s')
                            ->__toString()
                    );
                    if ($order->getCdate() && $order->getCdate() != '0000-00-00 00:00:00') {
                        $cloneOrder->setDateto(
                            DateTime_Object::FromString(
                                $order->getDateto()
                            )->addDay(
                                1 + DateTime_Differ::DiffDay(
                                    DateTime_Object::FromString($order->getDateto()),
                                    DateTime_Object::FromString($order->getCdate())
                                )
                            )
                        );
                    } else {
                        $cloneOrder->setDateto(
                            DateTime_Object::FromString(
                                $order->getDateto()
                            )->addDay(31)->setFormat('Y-m-d H:i:s')->__toString()
                        );
                    }

                    $cloneOrder->update();

                    $order->setNextid($cloneOrder->getId());
                    $order->update();

                    // копируем товары
                    $orderProducts = $order->getOrderProducts();
                    while ($orderProduct = $orderProducts->getNext()) {
                        $newOrderProduct = clone $orderProduct;
                        $newOrderProduct->setOrderid($cloneOrder->getId());
                        $newOrderProduct->unsetField('id');
                        $newOrderProduct->insert();
                    }

                    if ($data['products']) {
                        try {
                            $products = $cloneOrder->getOrderProducts();
                            while ($orderProduct  = $products->getNext()) {
                                try {
                                    $product = $orderProduct->getProduct();
                                    $orderProduct->setProductprice($product->makePrice($currencySystem));
                                    $orderProduct->update();
                                } catch (Exception $eproduct) {

                                }
                            }
                        } catch (Exception $eorderproducts) {

                        }
                    }

                    Shop::Get()->getShopService()->recalculateOrderSums($cloneOrder);
                }
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