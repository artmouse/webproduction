<?php
class orders_json_autocomplete_select2 extends Engine_Class {

    public function process() {
        try {
            $pageNum = $this->getArgument('pageNum');
            $pageSize = $this->getArgument('pageSize');
            $callback = $this->getArgument('callback');
            $searchTerm = $this->getArgument('searchTerm');

            $a = array();
            if ($searchTerm) {
                $orders = Shop::Get()->getShopService()->searchOrders($searchTerm, $this->getUser());
                $count = $orders->getCount();
            } else {
                $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
                $count = 1000000;
            }

            $orders->setLimit(($pageNum-1)*$pageSize, $pageSize);

            while ($x = $orders->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'text' => htmlspecialchars($x->makeName(true))
                );
            }

            echo $callback . '(' . json_encode(array(
            'Results' => $a,
            'Total' => $count
            )) .')';

        } catch (Exception $e) {

        }

        exit();
    }

}