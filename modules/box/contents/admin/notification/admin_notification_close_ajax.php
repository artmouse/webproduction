<?php
class admin_notification_close_ajax extends Engine_Class {

    public function process() {
        try {

            $all = $this->getArgumentSecure('all');
            if ($all) {
                Shop::Get()->getNotificationService()->deleteAllNotification($this->getUser());

                echo json_encode(array('result' => 'ok'));
            } else {
                $order = Shop::Get()->getShopService()->getOrderByID(
                    $this->getArgument('id')
                );

                $cuser = $this->getUser();

                Shop::Get()->getShopService()->deleteNotification(
                    $cuser,
                    $order
                );

                echo json_encode(array('result' => 'ok'));
            }

        } catch (Exception $ge) {
            echo json_encode(array('error' => 'error'));
        }
        exit();
    }

}