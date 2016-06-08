<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class ShopNotification extends XShopNotification {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * Next
     *
     * @return ShopNotification
     */
    public function getNext($exception = false) {
        1;
        return parent::getNext($exception);
    }

    /**
     * Get
     *
     * @return ShopNotification
     */
    public static function Get($key) {
        return self::GetObject('ShopNotification', $key);
    }

    /**
     * Получить пользователя
     *
     * @return User
     */
    public function getUser() {
        return Shop::Get()->getUserService()->getUserByID($this->getUserid());
    }

    /**
     * Получить комментарий
     *
     * @return CommentsAPI_XComment
     */
    public function getComment() {
        $x = new CommentsAPI_XComment($this->getCommentid());
        if ($x) {
            return $x;
        }
        throw new ServiceUtils_Exception();
    }

    /**
     * Получить заказ
     *
     * @return ShopOrder
     */
    public function getOrder() {
        return Shop::Get()->getShopService()->getOrderByID($this->getOrderid());
    }
}