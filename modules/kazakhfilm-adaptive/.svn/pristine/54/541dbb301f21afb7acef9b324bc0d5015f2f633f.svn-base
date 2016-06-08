<?php
class block_callback extends Engine_Class {

    public function process() {
        // прием заказного звонка
        if ($this->getArgumentSecure('call')) {
            try {
                if ($this->getControlValue('ajs') != 'ready') {
                    throw new ServiceUtils_Exception('bot');
                }

                try {
                    $user = $this->getUser();
                } catch (Exception $e) {
                    $user = Shop::Get()->getUserService()->addUserClient(
                        $this->getControlValue('cbname'),
                        false,
                        false,
                        false,
                        $this->getControlValue('cbphone'),
                        false, // address
                        false, // company
                        false, // department
                        false, // time
                        false, // comment admin
                        'callback' // group type
                    );
                }

                Shop::Get()->getCallbackService()->addCallback(
                    $this->getControlValue('cbname'),
                    $this->getControlValue('cbphone'),
                    '',//cbanswer
                    $user
                );

                $this->setValue('callmessage', 'ok');
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('callmessage', 'error');
                $this->setValue('callerrorsArray', $e->getErrorsArray());
            }
        }

        // заполняем по умолчанию данными форму callback'a
        try {
            $u = $this->getUser();

            if (!$this->getValue('call')) {
                $this->setControlValue('cbname', $u->getName());
                $this->setControlValue('cbphone', $u->getPhone());
            }
        } catch (Exception $e) {

        }
    }

}