<?php
/**
 * @copyright WebProduction
 * @package Shop
 */
class Shop_Event_OrderComment extends Events_Event {

    public function setOrder(ShopOrder $order) {
        $this->_order = $order;
    }

    /**
     * @return ShopOrder
     */
    public function getOrder() {
        return $this->_order;
    }

    public function setComment($comment) {
        $this->_comment = $comment;
    }

    public function getComment() {
        return $this->_comment;
    }

    public function setUser($user) {
        $this->_user = $user;
    }

    public function getUser() {
        return $this->_user;
    }

    private $_order;

    private $_comment;

    private $_user;

}