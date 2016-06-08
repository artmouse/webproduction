<?php
/**
 * OneBox
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

$file = @$argv[1];
if (!file_exists($file)) {
    print "No file exists.\n";
    return;
}

$xml = simplexml_load_string(file_get_contents($file));
//print_r($xml);

$number = trim($xml->ds['n'].'');
print "Number = {$number}\n";

foreach ($xml->ds->i as $x) {
    //print_r($x);

    $type = trim($x['s'].'');
    if ($type != 'Телеф.') {
        continue;
    }

    $date = DateTime_Formatter::DateTimeISO9075($x['d'].'');
    $duration = $x['du'].'';

    if (preg_match("/^<--(\d+)$/ius", $x['n'].'', $r)) {
        $from = $r[1];
        $to = $number;
    } else {
        $from = $number;
        $to = $x['n'].'';
    }

    print "Date = $date\n";
    print "From = $from\n";
    print "To = $to\n";
    print "Duration = $duration\n";

    try {
        SQLObject::TransactionStart();

        $event = new ShopEvent();
        $event->setType('call');
        $event->setCdate($date);
        $event->setFrom($from);
        $event->setTo($to);
        if (!$event->select()) {
            $event->insert();
        }

        EventService::Get()->processEventParameters($event);

        SQLObject::TransactionCommit();

        print "Event #".$event->getId()."\n";
    } catch (Exception $e) {
        SQLObject::TransactionRollback();
    }

    print "\n";
}

print "\n\ndone.\n\n";