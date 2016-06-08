<?php
class shop_forms_bonus_cart extends Engine_Class {

    public function process() {
        try {
            if ($this->getArgumentSecure('ok')) {
                $name = trim($this->getControlValue('name'));
                $phone = trim($this->getControlValue('phone'));
                $email = trim($this->getControlValue('email'));
                $code = trim($this->getControlValue('code'));

                if (!Checker::CheckPhone($phone) || !$phone) {
                    throw new ServiceUtils_Exception('Ошибка ввода в поле Телефон');
                }
                
                if (!Checker::CheckEmail($email) && $email) {
                    throw new ServiceUtils_Exception('Ошибка ввода в поле Email');
                }

                if (!$code) {
                    throw new ServiceUtils_Exception('Ошибка - пустой код');
                }
                session_start();
                // Сравниваем
                if (!isset($_SESSION['captcha']) || strtoupper($_SESSION['captcha']) != strtoupper($code)) {
                    throw new ServiceUtils_Exception('Ошибка - неверный код');
                }
                //--Удаляем из сессии код капчи
                unset($_SESSION['captcha']);
                
                $this->setValue('message', 'success');
                
                // подготовка письма о новой бонусной карте
                $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');
                $subj = 'Заказ бонусной карты '.$name;
                $body = 'Заказана бонусная карта';
                $body .= "<br>Имя ".$name."<br>Телефон ".$phone."<br>email ".$email;
                // получаем все емейлы на которые нужно отправить уведомление
                $emails = Shop::Get()->getSettingsService()->getSettingValue('email-orders');
                $emailArray = $this->_extractEmailArray($emails);
                
                // отправляем
                foreach ($emailArray as $emailTo) {
                    Shop::Get()->getUserService()->sendEmail($emailFrom, $emailTo, $subj, $body);
                }
                header('Location: /blagodarim', true);
            }
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
            $this->setValue('message', 'error');
            $this->setValue('errorsarray', $e->getErrorsArray());
        }
    }

    private function _extractEmailArray($text) {
        $text = str_replace(array("\r", "\n", "\t"), ' ', $text);
        $text = preg_replace("/([\s\,\;]+)/ius", ' ', $text);
        $orderEmailsArray = explode(' ', $text);
        $a = array();
        foreach ($orderEmailsArray as $x) {
            $x = trim($x);
            if (Checker::CheckEmail($x)) {
                $a[] = $x;
            }
        }
        return $a;
    }

}