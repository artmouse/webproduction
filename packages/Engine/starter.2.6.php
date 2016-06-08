<?php
/**
 * WebProduction Packages
 * @copyright (C) 2007-2012 WebProduction <webproduction.com.ua>
 *
 * This program is commercial software;
 * you can not distribute it and/or modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webprodiction.com.ua>
 * @copyright WebProduction
 * @package Engine
 *
 * @deprecated
 * @see starter.php
 */

/**
 * Стартер Engine в режиме 2.6
 * - В этом режиме неоходимы директории contents и файлы contents.*
 * - В этом режиме по умолчанию НЕ доступны FClasses
 * - В этом режиме по умолчанию НЕ подключаются все css и js файлы
 */

// подключаем пакет движка
include(dirname(__FILE__).'/include.2.6.php');
// вызываем
print Engine::Get()->execute()->__toString();