<?php
/**
 * SMSUtils
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   SMSUtils
 */

if (class_exists('PackageLoader')) {
    PackageLoader::Get()->import('SQLObject');

    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SMSUtils.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SMSUtils_ISender.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SMSUtils_Exception.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SMSUtils_SenderTurbosmsua.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SMSUtils_SenderSMSCru.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SMSUtils_SenderSMSCkz.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SMSUtils_SenderQueDB.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SMSUtils_DB.class.php');

    Events::Get()->observe('SQLObject.build.before', 'SMSUtils_DB');
} else {
    include_once(dirname(__FILE__).'/SMSUtils.class.php');
    include_once(dirname(__FILE__).'/SMSUtils_ISender.class.php');
    include_once(dirname(__FILE__).'/SMSUtils_Exception.class.php');
    include_once(dirname(__FILE__).'/SMSUtils_SenderTurbosmsua.class.php');
    include_once(dirname(__FILE__).'/SMSUtils_SenderSMSCkz.class.php');
    include_once(dirname(__FILE__).'/SMSUtils_SenderSMSCru.class.php');
    include_once(dirname(__FILE__).'/SMSUtils_SenderQueDB.class.php');
}