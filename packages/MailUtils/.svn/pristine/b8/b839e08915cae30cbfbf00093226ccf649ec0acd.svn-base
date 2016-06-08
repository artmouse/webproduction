<?php
/**
 * WebProduction Packages
 *
 * @copyright (C) 2007-2016 WebProduction <webproduction.ua>
 *
 * This program is free software; you can not redistribute it and/or
 * modify it.
 */

/**
 * MailUtils
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   MailUtils
 */

if (class_exists('PackageLoader')) {
    PackageLoader::Get()->import('Smarty');
    PackageLoader::Get()->import('SQLObject');

    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_Letter.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_Config.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_Smarty.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_SmartySender.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_ISender.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_SenderMail.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_SenderSMTP.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_SenderQueDB.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_SMTP.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_Exception.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_DB.class.php');

    Events::Get()->observe('SQLObject.build.before', 'MailUtils_DB');
} else {
    include_once(dirname(__FILE__).'/MailUtils_Letter.class.php');
    include_once(dirname(__FILE__).'/MailUtils_Config.class.php');
    include_once(dirname(__FILE__).'/MailUtils_Smarty.class.php');
    include_once(dirname(__FILE__).'/MailUtils_SmartySender.class.php');
    include_once(dirname(__FILE__).'/MailUtils_ISender.class.php');
    include_once(dirname(__FILE__).'/MailUtils_SenderMail.class.php');
    include_once(dirname(__FILE__).'/MailUtils_SenderSMTP.class.php');
    include_once(dirname(__FILE__).'/MailUtils_SenderQueDB.class.php');
    include_once(dirname(__FILE__).'/MailUtils_SMTP.class.php');
    include_once(dirname(__FILE__).'/MailUtils_Exception.class.php');
}