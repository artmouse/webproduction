<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ValidatorParentId extends Forms_AValidator {

    public function validate($data) {
        if ($this->getDisallowID() === false) {
            return true;
        }

        return ($this->getDisallowID() != $data);
    }

    public function setDisallowID($id) {
        $this->_disallowID = $id;
    }

    public function getDisallowID() {
        return $this->_disallowID;
    }

    private $_disallowID = false;

}