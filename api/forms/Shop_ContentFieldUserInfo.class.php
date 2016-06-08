<?php
/**
 * OneBox
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class Shop_ContentFieldUserInfo extends Forms_ContentFieldSelectList {

    public function __construct($keyValue, $full = false) {
        parent::__construct($keyValue, true);

        $this->_full = $full;

        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();
        $key = $this->getKey();
        $keyPrimary = $this->getDataSourceGroup()->getFieldPrimary()->getKey();

        $userid = @$cellsArray[$key];
        if ($userid) {
            try {
                $user = Shop::Get()->getUserService()->getUserByID($userid);

                try {
                    $assigns['url'] = $user->makeURLEdit();
                } catch (Exception $ue) {

                }

                if ($this->_full) {
                    $format = true;
                } else {
                    $format = 'lf';
                }

                $assigns['name'] = $user->makeName(true, $format);
                $assigns['id'] = $user->getId();
            } catch (Exception $e) {
                $assigns['name'] = $userid;
            }
        }

        return $this->getContentView()->render($assigns);
    }

    private $_full = false;

}