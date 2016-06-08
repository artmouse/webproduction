<?php
class notify_block extends Engine_Class {

    public function process() {
        $key = $this->getValue('key');

        $notify = IssueService::Get()->getIssuesAll($this->getUser());
        $notify->addWhere('linkkey', $key.'-%', 'LIKE');
        $notify->setDateclosed('0000-00-00 00:00:00');
        $a = array();
        while ($x = $notify->getNext()) {
        	$a[] = array(
        	'id' => $x->getId(),
        	'name' => $x->getName(),
        	'date' => DateTime_Formatter::DateTimePhonetic($x->getCdate()),
        	'url' => $x->makeURLEdit(),
        	);
        }
        $this->setValue('notifyArray', $a);
    }

}