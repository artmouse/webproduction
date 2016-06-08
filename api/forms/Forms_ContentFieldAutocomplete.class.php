<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2015 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Forms autocomplete users
 * @author dleonov
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ContentFieldAutocomplete extends Forms_ContentField {

    public function __construct($key) {
        parent::__construct($key);

        $this->getContentControl()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderControl($value = false) {
        $user = new User($value);
        $assigns = array();
        $assigns['name'] = $this->getName();
        $assigns['key'] = $this->getKey();
        $assigns['value'] = $value;
        $assigns['client_name'] = $user->makeName();
        $assigns['control_value'] = @htmlspecialchars($value);

        return $this->getContentControl()->render($assigns);
    }

}