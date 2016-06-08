<?php

/**
 * OneBox
 * 
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Forms_ContentFieldImageCrop
 * 
 * @author a.lazarenko
 * @package form
 */
class Forms_ContentFieldImageCrop extends Forms_ContentField {

    public function __construct($key) {

        PackageLoader::Get()->registerJSFile('/_js/jquery.imgareaselect.pack.js');
        PackageLoader::Get()->registerCSSFile('/_css/imgareaselect-default.css');
        PackageLoader::Get()->registerJSFile('/_js/cropper.min.js');
        PackageLoader::Get()->registerCSSFile('/_css/cropper.css');

        parent::__construct($key);

        $this->getContentView()->setFileHTML(dirname(__FILE__) . '/' . __CLASS__ . '.html');
        $this->getContentControl()->setFileHTML(dirname(__FILE__) . '/' . __CLASS__ . '_Control.html');

        $this->getContentControl()->setTranslateArray(
            Shop::Get()->getTranslateService()->getTranslateArray()
        );
    }

}