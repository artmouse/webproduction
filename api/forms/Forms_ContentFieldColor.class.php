<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2015 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @author Andrii Andriiets
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ContentFieldColor extends Forms_ContentField {

    public function __construct($key) {
        parent::__construct($key);

        $this->getContentControl()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

}