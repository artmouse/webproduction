<?php
if (class_exists('XCMSE')) {
    XCMSE::Get()->includePermanentJS(str_replace(PROJECT_PATH, '/', str_replace('\\', '/', dirname(__FILE__))).'/ckeditor/ckeditor.js');
} elseif (class_exists('PackageLoader')) {
    PackageLoader::Get()->registerJSFile(dirname(__FILE__).'/ckeditor/ckeditor.js', true);
} else {
    throw new Exception("Cannot include this package without package XCMSE", 0);
}