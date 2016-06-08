<?php
class voip_call_transfer extends Engine_Class {

    public function process() {
        try {
            $callID = $this->getArgument('callid');
            $phone = $this->getArgument('phone');

            $debug = VoIPService::Get()->transferCall($callID, $phone);
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