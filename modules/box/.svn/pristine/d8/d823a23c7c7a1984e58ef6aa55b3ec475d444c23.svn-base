<?php
/**
 * OneBox
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

$ami = Engine::Get()->getConfigField('asterisk-ami');

$host = $ami['host'];
$port = $ami['port'];
$login = $ami['login'];
$password = $ami['password'];

$numberProcessor = false;
try {
    $numberProcessorClass = Engine::Get()->getConfigField('project-box-event-parser-call-processor');

    if (class_exists($numberProcessorClass)) {
        $numberProcessor = new $numberProcessorClass();
    }
} catch (Exception $e) {

}


// трансфер входящего звонка
/*$a = array();
$a['Action'] = 'Redirect';
$a['Channel'] = 'SIP/701-00000eea';
$a['Context'] = 'wp-phones';
$a['Exten'] = '201';
$a['Priority'] = '1';*/

/*$a = array();
$a['Action'] = 'Redirect';
$a['Channel'] = ' SIP/zadarma-sales-kz-00000ee5';
$a['Context'] = 'wp-phones';
$a['Exten'] = '201';
$a['Priority'] = '1';*/

// положить трубку
/*$a = array();
$a['Action'] = 'Hangup';
$a['Channel'] = 'SIP/701-00000ef3';*/

/*// поднять трубку
// AGI(agi:async)
$a = array();
$a['Action'] = 'AGI';
$a['Channel'] = 'SIP/601';
$a['Command'] = 'ANSWER';
$a['Exten'] = '201';*/

$data = ami_command($host, $port, $login, $password, $a);
print $data;


print "\n\ndone.\n\n";

function ami_command($host, $port, $login, $password, $paramArray) {
    $socket = fsockopen($host, $port, $errno, $errstr, 3);
    if (!$socket) {
        throw new ServiceUtils_Exception($errstr, $errno);
    }

    fputs($socket, "Action: Login\r\n");
    fputs($socket, "UserName: {$login}\r\n");
    fputs($socket, "Secret: {$password}\r\n\r\n");
    foreach ($paramArray as $key => $value) {
        fputs($socket, "{$key}: {$value}\r\n");
    }
    fputs($socket, "\r\n");

    fputs($socket, "Action: Logoff\r\n\r\n");

    $data = '';
    while (!feof($socket)) {
        $data .= fgets($socket);
    }
    fclose($socket);

    return $data;
}