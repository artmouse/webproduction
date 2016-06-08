<?php

class Shop_Event_OrderEmployer extends Events_Event {

    /**
     * SetOrder
     *
     * @param ShopOrder $order
     */
    public function setOrder(ShopOrder $order) {
        $this->_order = $order;
    }

    /**
     * GetOrder
     *
     * @return ShopOrder
     */
    public function getOrder() {
        return $this->_order;
    }

    /**
     * SetEmployer
     *
     * @param ShopOrderEmployer $employer
     */
    public function setEmployer(ShopOrderEmployer $employer) {
        $this->_employer = $employer;
    }

    /**
     * GetEmployer
     *
     * @return ShopOrderEmployer
     */
    public function getEmployer() {
        return $this->_employer;
    }

    /**
     * SetEmployerOldDate
     *
     * @param $employer
     */
    public function setEmployerOldDate($employerDate) {
        $this->_employerOldDate = $employerDate;
    }

    /**
     * GetEmployerOldDate
     *
     * @return String
     */
    public function getEmployerOldDate() {
        return $this->_employerOldDate;
    }

    private $_order;
    private $_employer;
    private $_employerOldDate;

}