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
class Datasource_UserManager extends Datasource_Users {

    public function getSQLObject() {
        $users = parent::getSQLObject();
        $users->addWhere('level', 2, '>=');
        return $users;
    }

}