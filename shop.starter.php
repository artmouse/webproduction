<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

//xdebug_start_trace(dirname(__FILE__).'/xdebug_'.date('YmdHis').'.log');

/*function _shop_error_handler() {
    $ip = @$_SERVER['REMOTE_ADDR'];
    if (!$ip || $ip == '127.0.0.1') {
    	return false;
    }

    $errorArray = error_get_last();

    if ($errorArray['type'] == 8) {
    	return false;
    }

    $body = '';
    $body .= 'Type = '.$errorArray['type']."\n";
    $body .= 'Message = '.$errorArray['message']."\n";
    $body .= 'File = '.$errorArray['file']."\n";
    $body .= 'Line = '.$errorArray['line']."\n";
    $body .= 'Host = '.@$_SERVER['HTTP_HOST']."\n";
    $body .= "\n";
    $body .= 'Trace: '.print_r(debug_backtrace(false), true);

    $email = 'error@webproduction.ua';
    $subject = trim('Error handler '.@$_SERVER['HTTP_HOST']);

    $content = '';
    $content .= "From: {$email}\n";
    $content .= "MIME-Version: 1.0\n";
    $content .= "Content-Type: text/plain; charset=UTF-8\n";
    $content .= "Content-Transfer-Encoding: 8bit\n";
    $content .= "\n";
    $content .= $body;
    $content .= "\n";

    mail($email, $subject, '', $content);

    return false;
}*/

// регистрируем обработчик fatal error
// register_shutdown_function('_shop_error_handler');
// set_error_handler('_shop_error_handler', E_ALL);

// подключаем пакет движка
include(dirname(__FILE__).'/packages/Engine/include.2.6.php');

// вызываем
echo Engine::Get()->execute()->__toString();

//xdebug_stop_trace();