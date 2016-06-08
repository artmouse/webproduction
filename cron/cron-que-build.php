<?php

$outputQueMinute = '/etc/cronque.minute.sh';
$outputQueHour = '/etc/cronque.hour.sh';
$outputQueDay = '/etc/cronque.day.sh';

$outputQueArray = array();
$outputQueArray['cron.minute.conf'] = array();
$outputQueArray['cron.hour.conf'] = array();
$outputQueArray['cron.day.conf'] = array();

exec("find /var/www/clients -mindepth 1 -maxdepth 1 -type d", $a1);
foreach ($a1 as $x1) {
    $a2 = array();
    exec("find $x1 -mindepth 1 -maxdepth 1 -type d 2>/dev/null", $a2);
    foreach ($a2 as $x2) {

        foreach ($outputQueArray as $key => $tmp) {
            $fileCronMinute = $x2.'/web/'.$key;
            $data = @file_get_contents($fileCronMinute);
            if ($data) {
                $dataArray = explode("\n", $data);
                foreach ($dataArray as $data) {
                    $data = trim($data);
                    if (!$data) {
                        continue;
                    }
                    $data = str_replace('~', $x2.'/web', $data);

                    $login = posix_getpwuid(fileowner($fileCronMinute));
                    $login = @$login['name'];

                    if ($login) {
                        $data = 'sudo -u '.$login.' '.$data;
                    }

                    /*if (!substr_count($data, '>')) {
                        $data .= ' >/dev/null 2>&1';
                    }*/

                    $outputQueArray[$key][] = 'echo "'.$data.'"';
                    $outputQueArray[$key][] = $data;
                }

            }
        }
    }
}

//print_r($outputQueArray);
foreach ($outputQueArray as $key => $data) {
    print $key.' - '.(count($data)/2)."\n";

    $file = '/etc/'.str_replace('.conf', '.que.sh', $key);
    file_put_contents(
        $file,
        implode("\n", $data)."\n",
        LOCK_EX
    );

    chmod($file, 0755);
}

print "\n\ndone.\n\n";