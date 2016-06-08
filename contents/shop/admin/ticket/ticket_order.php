<?php
class ticket_order extends Engine_Class {

    public function process() {
        if ($this->getArgumentSecure('ok')) {
            try {
                $message = $this->getControlValue('message');
                $message .= "\n\n";

                $serviceArray = $this->getArgumentSecure('service');
                if ($serviceArray) {
                    $message .= "Отмеченные услуги:\n";
                    $message .= implode("\n", $serviceArray);
                }

                Shop::Get()->getShopService()->sendTicketSupport(
                $this->getControlValue('name'),
                $this->getControlValue('email'),
                $message
                );

                $this->setValue('message', 'ok');
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $e->getErrorsArray());
            }
        }

        $this->setControlValue('email', Shop::Get()->getSettingsService()->getSettingValue('header-email'));

        $data = @file_get_contents('http://services1.webproduction.ua');
        if ($data) {
            $a = json_decode($data, true);
            $this->setValue('serviceArray', $a);
        }
    }

}