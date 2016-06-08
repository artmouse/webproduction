<?php
class user_add extends Engine_Class {

    public function process() {
        $result = false;
        $errorsArray = array();

        try {
            $user = Shop::Get()->getUserService()->addUserClient(
                $this->getArgumentSecure('name'),
                $this->getArgumentSecure('namelast'),
                $this->getArgumentSecure('namemiddle'),
                $typeSex = $this->getArgumentSecure('typesex'),
                $this->getArgumentSecure('company'),
                $this->getArgumentSecure('post'),
                $this->getArgumentSecure('email'),
                $this->getArgumentSecure('phone'),
                $this->getArgumentSecure('address')
            );
            if (Shop::Get()->getSettingsService()->getSettingValue('user-add-source-field')) {
                if (!$this->getArgumentSecure('sourceid')) {
                    throw new ServiceUtils_Exception('nosourceid');
                }
            }
            $whatsapp = $this->getArgumentSecure('whatsapp');
            $skype = $this->getArgumentSecure('skype');
            $sourceid = $this->getArgumentSecure('sourceid');
            if ($whatsapp) {
                $user->setWhatsapp($whatsapp);
            }
            if ($skype) {
                $user->setSkype($skype);
            }
            if ($sourceid) {
                $user->setSourceid($sourceid);
            }
            
            $user->setDistribution(1);
            $user->update();

            $result = array(
                'id' => $user->getId(),
                'name' => htmlspecialchars($user->getName()),
                'namelast' => htmlspecialchars($user->getNamelast()),
                'namemiddle' => htmlspecialchars($user->getNamemiddle()),
                'company' => htmlspecialchars($user->getCompany()),
                'email' => htmlspecialchars($user->getEmail()),
                'phone' => htmlspecialchars($user->getPhone()),
                'skype' => htmlspecialchars($user->getSkype()),
                'whatsapp' => htmlspecialchars($user->getWhatsapp()),
                'sourceid' => htmlspecialchars($user->getSourceid()),
            );
            $status = 'success';
        } catch (ServiceUtils_Exception $e) {
            $status = 'error';
            foreach ($e->getErrorsArray() as $error) {
                if ($error == 'phone') {
                    $errorsArray[] = 'Неверный формат номера телефона.';
                }

                if ($error == 'email') {
                    $errorsArray[] = 'Неверный формат Email.';
                }

                if ($error == 'name') {
                    $errorsArray[] = 'Имя - обязательно.';
                }

                if ($error == 'notUnicCompany') {
                    $errorsArray[] = 'Компания уже существует.';
                }

                if ($error == 'duplicate') {
                    $errorsArray[] = 'Контакт уже существует.';
                }

                if ($error == 'nosourceid') {
                    $errorsArray[] = 'Укажите источник или канал.';
                }
            }
        }

        $json = array(
        'status' => $status,
        'result' => $result,
        'errors' => $errorsArray
        );

        echo json_encode($json);
        exit();
    }

}