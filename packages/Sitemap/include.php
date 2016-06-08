<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Sitemap
 */
if (class_exists('PackageLoader')) {
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Sitemap.class.php');
} else {
    include_once(dirname(__FILE__).'/Sitemap.class.php');
}