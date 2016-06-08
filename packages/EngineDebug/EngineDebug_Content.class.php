<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can redistribute it and/or
 * modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package EngineDebug
 */
class EngineDebug_Content extends Engine_Class {

    public function process() {
        $key = $this->getArgument('key');
        $this->setValue('html', file_get_contents(dirname(__FILE__).'/tmp/'.$key));

        PackageLoader::Get()->import('UIWPP');

        $this->setValue('jQuery', PackageLoader::Get()->isImported('jQuery'));
    }

}