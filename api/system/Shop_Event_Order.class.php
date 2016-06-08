<?php

class Shop_Event_Order extends Events_Event {

    /**
     * Задать заказ
     *
     * @param ShopOrder $order
     */
    public function setOrder(ShopOrder $order) {
        $this->_order = $order;
    }

    /**
     * Получить заказ
     *
     * @return ShopOrder
     */
    public function getOrder() {
        return $this->_order;
    }

    /**
     * Задать статус
     *
     * @param ShopOrderStatus $status
     */
    public function setStatus(ShopOrderStatus $status) {
        $this->_status = $status;
    }

    /**
     * Получить статус
     *
     * @return ShopOrderStatus
     */
    public function getStatus() {
        return $this->_status;
    }

    /**
     * Задать юзера
     *
     * @param User $user
     */
    public function setUser(User $user) {
        $this->_user = $user;
    }

    /**
     * Получить юзера
     *
     * @return User
     */
    public function getUser() {
        return $this->_user;
    }

    private $_order;

    private $_user;

    private $_status;


}