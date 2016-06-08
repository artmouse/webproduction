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
class Forms_ContentTableHeaders extends Forms_Content {

    public function __construct() {
        $this->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function render(Forms_ContentTable $table) {
        $assigns = array();

        $sortType = Engine::Get()->GetURLParser()->getArgumentSecure('sorttype');
        if ($sortType == 'ASC') {
        	$sortType = 'DESC';
        } else {
            $sortType = 'ASC';
        }

        $a = array();
        foreach ($table->getFieldsArray() as $object) {
        	$a[] = array(
        	'name' => $object->getName(),
        	'key' => $object->getKey(),
        	'url' => $object->getSortable() ? Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('sortkey' => $object->getKey(), 'sorttype' => $sortType)) : false,
        	);
        }
        $assigns['headersArray'] = $a;

        $assigns['sortkey'] = Engine::GetURLParser()->getArgumentSecure('sortkey');
        $assigns['sorttype'] = Engine::GetURLParser()->getArgumentSecure('sorttype');

        return parent::render($assigns);
    }

}