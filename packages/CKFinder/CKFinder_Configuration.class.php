<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2010  WebProduction <webproduction.com.ua>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU LESSER GENERAL PUBLIC LICENSE
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

/**
 * @author Max
 * @copyright WebProduction
 * @package CKFinder
 */
class CKFinder_Configuration {

    private function __construct() {
        if (!session_id()) {
            @session_start();
        }

        $this->setAuthorized(false);
    }

    /**
     * @var CKFinder_Configuration
     */
    private static $_Instance = null;

    /**
     * @return CKFinder_Configuration
     */
    public static function Get() {
        if (!self::$_Instance) {
        	self::$_Instance = new CKFinder_Configuration();
        }
        return self::$_Instance;
    }

    /**
     * Установить авторизацию для CKFinder'a
     *
     * @param bool $auth
     */
    public function setAuthorized($auth = true) {
        $_SESSION['authorized'] = $auth;
    }

}