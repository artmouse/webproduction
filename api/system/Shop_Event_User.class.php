<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_Event_User extends Events_Event {

    /**
     * @param User $user
     */
    public function setUser(User $user) {
        $this->_user = $user;
    }

    /**
     * @return User
     */
    public function getUser() {
        return $this->_user;
    }

    private $_user;

}