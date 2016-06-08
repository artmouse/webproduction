<?php
class voip_call_reject extends Engine_Class {

    public function process() {
        try {
            $callID = $this->getArgument('callid');

            $debug = VoIPService::Get()->hangupCall($callID);
            if (PackageLoader::Get()->getMode('debug')) {
                print $debug;
            }

            print 'success';
        } catch (Exception $e) {
            print 'error';
        }
        exit();
    }

}