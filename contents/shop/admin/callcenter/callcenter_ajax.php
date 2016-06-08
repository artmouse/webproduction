<?php
class callcenter_ajax extends Engine_Class {

    public function process() {
        $voip = new XShopUserVoIP();
        $a = array();
        while ($x = $voip->getNext()) {
            try {
        	    $from = Shop::Get()->getUserService()->findUserByContact($x->getCallerid(), 'call');
        	    $fromName = $from->makeName();
        	    $fromURL = $from->makeURLEdit();
        	} catch (Exception $e) {
        	    $fromName = false;
        	    $fromURL = false;
        	}

        	try {
        	    $to = Shop::Get()->getUserService()->findUserByContact($x->getPhone(), 'call');
        	    $toName = $to->makeName();
        	    $toURL = $to->makeURLEdit();
        	} catch (Exception $e) {
        	    $toName = false;
        	    $toURL = false;
        	}

        	$a[] = array(
        	'from' => $x->getCallerid(),
        	'fromName' => $fromName,
        	'fromURL' => $fromURL,
        	'to' => $x->getPhone(),
        	'toName' => $toName,
        	'toURL' => $toURL,
        	);
        }
        $this->setValue('voipArray', $a);
    }

}