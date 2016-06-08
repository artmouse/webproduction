<?php
class ajax_admin_send_sms extends Engine_Class {

    public function process() {
        $sms = $this->getArgumentSecure('sms');
        $content = $this->getArgumentSecure('content');
        $result = false;
        if ($sms && $content) {
            try {
                Shop::Get()->getUserService()->sendSMS(
                    $sms,
                    $content,
                    $this->getUser()
                );

                $result = true;
            } catch (Exception $mailEx) {
                $result = false;
            }
        }
        echo $result;
        exit();
    }

}