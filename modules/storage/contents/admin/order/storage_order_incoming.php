<?php
class storage_order_incoming extends Engine_Class {

    public function process() {
        // таблица заказов
        $table = new Shop_ContentTable(new Datasource_OrdersForIncoming());
        $table->setRow(new Shop_ContentTableRowOrders());
        $table->setLinesOnPage(10);
        $this->setValue('table', $table->render());
    }

}