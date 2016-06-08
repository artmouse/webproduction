<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ContentFieldFileImage extends Forms_ContentFieldFile {

	public function __construct($key, $filemd5 = true) {
	    parent::__construct($key, $filemd5);

	    $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
	    $this->getContentControl()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'_Control.html');
	}

}