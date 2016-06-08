<?php
class box_block_write_letter extends Engine_Class {

    /**
     * Получить заказ
     *
     * @return ShopOrder
     */
    private function _getOrder() {
        return $this->getValue('order');
    }

    public function process() {
        // получаем заказ
        $order = $this->_getOrder();
        $process = $this->getValue('process');

        // текущий авторизированный пользователь
        $user = $this->getUser();
        $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);

        PackageLoader::Get()->registerJSFile('/_js/admin/comment.js');

        // когда нажата кнопка Сохранить
        if (!$process && $canEdit && $this->getControlValue('ok')) {

            $fileIDArray = $this->getArgumentSecure('fileid_write_letter', 'array');

            if ($this->getArgumentSecure('post_letter_email_write_letter')) {
                $emails = explode(',', $this->getArgumentSecure('post_letter_email_write_letter'));
                foreach ($emails as $email) {
                    $email = trim($email);

                    if (strlen($email) < 5) {
                        continue;
                    }

                    $comment = $this->getArgumentSecure('postcomment_write_letter');

                    if ($comment || $fileIDArray) {

                        $emailFrom = $this->getArgumentSecure('post_letter_email_from_write_letter');
                        if (!$emailFrom) {
                            $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('box-parser-email');

                            if (!$emailFrom) {
                                $emailFrom = Shop::Get()->getSettingsService()->getSettingValue(
                                    'reverse-email'
                                );
                            }
                        }

                        $subject = trim($this->getArgumentSecure('post_letter_subject_write_letter'));
                        if (!$subject) {
                            $subject = $order->getName();
                        }

                        $subject .= ' #'.$order->getId();

                        $fileAttachedArray = array();
                        foreach ($fileIDArray as $fileID) {
                            try {
                                $file = Shop::Get()->getFileService()->getFileByID($fileID);

                                $fileAttachedArray[] = array(
                                    'name' => $file->getName(),
                                    'type' => $file->getContenttype(),
                                    'tmp_name' => $file->makePath()
                                );
                            } catch (ServiceUtils_Exception $fse) {

                            }
                        }
                        
                        Shop::Get()->getUserService()->sendEmail(
                            $emailFrom,
                            $email,
                            $subject,
                            $comment,
                            'text',
                            $fileAttachedArray,
                            false,
                            $this->getUser(),
                            $this->getArgumentSecure('date_post_write_letter')
                        );

                        $commentEmail = $comment;
                        $commentEmail .= "\n\n";
                        $commentEmail .=
                            Shop::Get()->getTranslateService()->getTranslateSecure('translate_otpravleno_na_email_');
                        $commentEmail .= $email;
                        $commentEmail .= " с темой ".$subject;

                        Shop::Get()->getShopService()->addOrderEmail(
                            $order,
                            $this->getUser(),
                            $commentEmail,
                            $fileIDArray
                        );
                    }

                }
            }

        }

        $clientEmail = $order->getClientemail();
        if (!$clientEmail) {
            try{
                $clientEmail = $order->getClient()->getEmail();
            } catch (Exception $ee) {

            }
        }
        $this->setValue('clientPostEmail', $clientEmail);

        $emailFromArray = array();
        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('box-parser-email');
        if (!$emailFrom) {
            $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');
        }
        if ($emailFrom) {
            $emailFromArray[] = $emailFrom;
        }

        if (Checker::CheckEmail($user->getEmail())) {
            $emailFromArray[] = $user->getEmail();
        }
        $this->setValue('emailFromArray', $emailFromArray);

    }

}