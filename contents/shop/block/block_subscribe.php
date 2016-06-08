<?php
class block_subscribe extends Engine_Class {

    public function process() {
        // нажали на кнопку "Подписаться"
        if ($this->getArgumentSecure('distribution_ok')) {
            // подписка для юзера
            $succesfullySubscribe = false;
            try {
                $this->getUser()->setDistribution(1);
                $this->getUser()->update();

                $this->setValue('subscribe_message', 'ok');
                $succesfullySubscribe = true;
            } catch (Exception $uex) {
                // return;
            }

            // подписка для почты
            if ( $email = $this->getArgumentSecure('distribution_email')) {
                if (!Checker::CheckEmail($email)) {
                    $this->setValue('subscribe_message', 'error');
                    return;
                }

                try {
                    $user = Shop::Get()->getUserService()->addUserClient(
                        $email, // name
                        false, // namelast
                        false, // namemiddle
                        false, // typesex
                        false, // company
                        false, // post
                        $email // email
                    );

                    $user->setDistribution(1);
                    $user->update();

                    $this->setValue('subscribe_message', 'ok');
                    $succesfullySubscribe = true;
                } catch (Exception $e) {
                    $this->setValue('subscribe_message', 'error');
                }
            }
            if (!$succesfullySubscribe) {
                $this->setValue('subscribe_message', 'error');
            }
        }

        // статус
        try {
            $this->setValue('useremail', $this->getUser()->getEmail());
            if ($this->getUser()->getDistribution()) {
                $this->setValue('subscribe_status', 'ok');
            }
        } catch (Exception $e) {

        }
    }

    /**
     * Doc
     *
     * @param bool $email
     * @param bool $user
     */
    private function _subscribe($email = false, $user = false) {
        if ($user) {
            $user->setDistribution(1);
            $user->update();
            return;
        }

        if ($email) {
            try {
                $user = Shop::Get()->getUserService()->getUserByEmail(@trim($email));
                $user->setDistribution(1);
                $user->update();
            } catch (ServiceUtils_Exception $e) {
                $user = new User();
                $user->setEmail($email);
                $user->setDistribution(1);
                $user->insert();
            }
        }
    }
}