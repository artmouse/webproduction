<?php
class voip_call_close extends Engine_Class {

    public function process() {
        try {
            $call = new XShopUserVoIP(
                $this->getArgument('callid')
            );

            if (!$call->getId()) {
                throw new ServiceUtils_Exception();
            }

            $call->setClosed(1);
            $call->update();
        } catch (Exception $e) {

        }
        exit();
    }

}