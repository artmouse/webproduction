<?php
require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

$ignoreArray = array();
$ignored = new XShopEventIgnore();
$ignored->setSpam(1);
while ($x = $ignored->getNext()) {
    $ignoreArray[] = $x->getAddress();
}

$skypeName = $argv[1];
$file_db = new PDO('sqlite:'.$argv[2]);

// Set errormode to exceptions
$file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//$result = $file_db->query("SELECT * FROM main.sqlite_master WHERE type='table';");

$result = $file_db->query('SELECT calls.id, calls.begin_timestamp, calls.is_incoming, callmembers.identity FROM calls JOIN callmembers ON call_db_id=calls.id');
$result->setFetchMode(PDO::FETCH_ASSOC);
foreach ($result as $x) {
    //print_r($x);

    if ($ignoreArray) {
        if (in_array($x['identity'], $ignoreArray)) {
            continue;
        }
    }

    if ($x['is_incoming']) {
        $from = $x['identity'];
        $to = $skypeName;
    } else {
        $from = $skypeName;
        $to = $x['identity'];
    }

    if (!$from || !$to) {
        continue;
    }

    $date = date('Y-m-d H:i:s', $x['begin_timestamp']);

    print "CallID = ".$x['id']."\n";
    print "Date = ".$date."\n";
    print "From = ".$from."\n";
    print "To = ".$to."\n";
    print "\n";

    // вставка Skype-звонка
    try {
        SQLObject::TransactionStart();

        $event = new ShopEvent();
        $event->setType('skype');
        $event->setFrom($from);
        $event->setTo($to);
        $event->setCdate($date);
        if (!$event->select()) {
            $event->setContent('Skype-звонок');
            $event->insert();

            EventService::Get()->processEventParameters($event);
        }

        SQLObject::TransactionCommit();

        print 'Call #'.$event->getId()."\n";
        print "\n";
    } catch (Exception $ge) {
        SQLObject::TransactionRollback();
        print $ge;
    }
}

$dataArray = array();

$result = $file_db->query('SELECT * FROM messages WHERE chatmsg_type=3');
$result->setFetchMode(PDO::FETCH_ASSOC);
foreach ($result as $x) {
    $date = date('Y-m-d H:i:s', $x['timestamp']);
    $message = $x['body_xml'];
    $message = strip_tags($message);
    $message = trim($message);

    $from = $x['author'];
    if ($from == $skypeName) {
        $to = $x['dialog_partner'];
    } else {
        $to = $skypeName;
    }

    if (!$message) {
        continue;
    }

    if (!$from || !$to) {
        continue;
    }

    if ($ignoreArray) {
        if (in_array($from, $ignoreArray)) {
            continue;
        }
        if (in_array($to, $ignoreArray)) {
            continue;
        }
    }

    $dateGroup = date('Y-m-d H', $x['timestamp']);
    $time = date('H:i:s', $x['timestamp']);

    /*print "MessageID = ".$x['id']."\n";
    print "Date = ".$date."\n";
    print "From = ".$from."\n";
    print "To = ".$to."\n";
    print "Message = ".$message."\n";
    print "\n";*/

    if (isset($dataArray[$dateGroup.'/'.$from.'/'.$to])) {
        $dataArray[$dateGroup.'/'.$from.'/'.$to] .= $time.' @'.$from.': '.$message."\n";
    } elseif (isset($dataArray[$dateGroup.'/'.$to.'/'.$from])) {
        $dataArray[$dateGroup.'/'.$to.'/'.$from] .= $time.' @'.$from.': '.$message."\n";
    } else {
        $dataArray[$dateGroup.'/'.$from.'/'.$to] = $time.' @'.$from.': '.$message."\n";
    }
}

$file_db = null;

foreach ($dataArray as $hash => $string) {
    $hash = explode('/', $hash);
    $date = $hash[0].':00:00';
    $from = $hash[1];
    $to = $hash[2];

    print "Date = ".$date."\n";
    print "From = ".$from."\n";
    print "To = ".$to."\n";
    print $string;
    print "\n\n\n";

    // вставка Skype-переписки
    try {
        SQLObject::TransactionStart();

        $event = new ShopEvent();
        $event->setType('skype');
        $event->setFrom($from);
        $event->setTo($to);
        $event->setCdate($date);
        if (!$event->select()) {
            $event->setContent($string);
            $event->insert();
        } else {
            $event->setContent($string);
            $event->update();
        }

        EventService::Get()->processEventParameters($event);

        SQLObject::TransactionCommit();

        print 'Message #'.$event->getId()."\n";
        print "\n";
    } catch (Exception $ge) {
        SQLObject::TransactionRollback();
        print $ge;
    }
}

print "\n\ndone\n";