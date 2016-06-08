<?php
class admin_notification_block extends Engine_Class {

    public function process() {
        try {
            // получаем текущего юзера
            $cuser = $this->_getUser();

            $notifications = Shop::Get()->getShopService()->getNotificationsByUser($cuser);

            $notificationArray = array(
                'comment' => array(),
                'email' => array(),
                'call' => array(),
                'notify' => array(),
                'change' => array(),
                'commentresult' => array(),
                '' => array()
            );

            $orderArray = array();
            $commentArray = array();

            while ($notification = $notifications->getNext()) {
                try {
                    $comment = $notification->getComment();

                    $content = $comment->getContent();

                    $a = array();

                    // выделение цветом
                    if (preg_match("/\[.*?#(\d+)\]/ius", $content, $r)) {
                        $userTo = $r[1];
                        // только для того юзера, для которого строим уведомения
                        if ($userTo == $cuser->getId()) {
                            $a['toUser'] = $r[0];
                            $a['contentWithOutUser'] = str_replace($r[0], '', $content);
                        }

                    }

                    $a['text'] = nl2br(htmlspecialchars(mb_substr($content, 0, 500)));
                    $a['date'] = DateTime_Formatter::DateTimePhonetic($comment->getCdate());

                    try {
                        $user = Shop::Get()->getUserService()->getUserByID(
                            $comment->getId_user()
                        );

                        $a['user'] = $user->makeName(true, 'lfm');
                        $a['userImage'] = $user->makeImageThumb(100);

                        $color = $user->makeColor();
                    } catch (Exception $userEx) {
                        $color = 'gray';
                    }

                    $orderID = $notification->getOrderid();
                    $commentArray[$orderID][] = $a;

                    if (!isset($orderArray[$orderID])) {
                        $order = $notification->getOrder();

                        $description = strip_tags($order->getComments());
                        $description = str_replace("\n", ' ', $description);
                        if (strlen($description) > 100) {
                            $description = nl2br(htmlspecialchars(mb_substr($description, 0, 100))).'...';
                        }

                        $orderArray[$orderID] = array(
                            'id' => $orderID,
                            'date' => DateTime_Formatter::DateTimePhonetic($order->getUdate()),
                            'name' => $order->makeName(),
                            'url' => $order->makeURLEdit(),
                            'color' => $color,
                            'description' => $description
                        );

                        $commentType = $comment->getType();
                        $notificationArray[$commentType][] = $orderID;
                    }

                    $orderArray[$orderID]['commentCount'] = count($commentArray[$orderID]);

                } catch (ServiceUtils_Exception $se) {

                }
            }
            $this->setValue('notificationArray', $notificationArray);
            $this->setValue('orderArray', $orderArray);
            $this->setValue('commentArray', $commentArray);

            $typeNameArray = array(
                'comment' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_kommmentarii'),
                'email' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_pisma'),
                'call' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_zvonki'),
                'notify' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_uvedomleniya'),
                'change' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_changes'),
                'commentresult' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_rezultat')
            );

            $this->setValue('typeNameArray', $typeNameArray);
        } catch (Exception $ge) {
            // print $ge;
        }
    }

    /**
     * Метод-обертка для типизации
     *
     * @return User
     */
    private function _getUser() {
        return $this->getValue('user');
    }

}