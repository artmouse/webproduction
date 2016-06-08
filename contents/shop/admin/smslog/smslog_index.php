<?php
class smslog_index extends Engine_Class {

    public function process() {
        try{
            $login = Shop::Get()->getSettingsService()->getSettingValue('sms-login');
            $pass = Shop::Get()->getSettingsService()->getSettingValue('sms-password');
            $sender = Shop::Get()->getSettingsService()->getSettingValue('sms-sender');

            // Подключаемся к серверу
            $client = new SoapClient('http://turbosms.in.ua/api/wsdl.html');

            // Данные авторизации
            $auth = array (
                'login' => $login,
                'password' => $pass
            );

            // Авторизируемся на сервере
            $result = $client->Auth($auth);

            // Получаем количество доступных кредитов
            $result = $client->GetCreditBalance();
            $balance = $result->GetCreditBalanceResult;
            if (is_numeric($balance)) {
                $this->setValue('balance', $balance);
            } else {
                $this->setValue('errorAuth', true);
            }

        } catch (Exception $e) {

        }

        if ($sender && $login && $pass) {
            $table = new Shop_ContentTable(new Datasource_SMSLog());
            $this->setValue('table', $table->render());
        } else {
            $this->setValue('false', true);
        }



    }

}