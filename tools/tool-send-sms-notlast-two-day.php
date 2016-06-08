<?php
 
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');
 
$que = new SMSUtils_XTurbosmsuaQue();
$que->setStatus(0);
$que->setResult('');
$date = DateTime_Object::Now()->addDay(-2)->setFormat('Y-m-d H:i:s')->__toString();

$que->addWhere('cdate', $date, '<=');

while ($x = $que->getNext()) {

    // отправляем sms
    $result = $sender->send($x->getSender(), $x->getTo(), $x->getContent());

    if ($result == "success") {
        $x->setPdate(date('Y-m-d H:i:s'));
        $x->setStatus(1);
    }
    // обновляем информацию в базе
    $x->setResult($result);
    $x->update();
    
}