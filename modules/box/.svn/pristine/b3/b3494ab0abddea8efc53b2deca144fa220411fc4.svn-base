<?php
class voip_call_originate extends Engine_Class {

    public function process() {
        $from = $this->getUser()->getPhone();
        $to = $this->getArgument('phone');
        $to = preg_replace("/\D/", '', $to);

        $debug = VoIPService::Get()->originateCall($from, $to);
        if (PackageLoader::Get()->getMode('debug')) {
            print $debug;
        }

        print 'success';
        exit();
    }

}