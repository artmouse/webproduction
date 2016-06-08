<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_UsersSortedByName extends Datasource_Users {

    public function getSQLObject() {
        $x = Shop::Get()->getUserService()->getUsersActive();
        $x->setOrder('name', 'ASC');
        return  $x;
    }
    
    public function getFieldPreview() {
        return $this->getField('login');
    }

}