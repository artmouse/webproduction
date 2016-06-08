<?php
class shop_guestbook extends Engine_Class {

    public function process() {
        Engine::GetHTMLHead()->setTitle(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_shop_opinions')
        );

        $this->setValue('isUserAuthorized', $this->isUserAuthorized());
        $this->setValue(
            'isUnregisteredUsers',
            Shop::Get()->getSettingsService()->getSettingValue('unregistered-users-to-post-reviews')
        );

        // добавление отзыва

        //если нажатая кнопка
        if ($this->getArgumentSecure('guestbook')) {
            $ex = new ServiceUtils_Exception();
            try {
                // получить отзыв
                $response = $this->getControlValue('response');
                // имя
                $name =  $this->getControlValue('name');
                // phone
                $phone = $this->getControlValue('phone');
                // email
                $email = $this->getControlValue('email');
                // orderNumber
                $orderNumber = $this->getControlValue('orderNumber');

                if (!$response) {
                    $ex->addError('response');
                    throw $ex;
                }
                //проверка на авторизацию пользователя
                if ($this->isUserAuthorized()) {
                    // получить зарегистрированного пользователя
                    $user = $this->getUser();
                    // можно ли оставлять отзывы незарегистрированным пользователям
                } elseif (Shop::Get()->getSettingsService()->getSettingValue('unregistered-users-to-post-reviews') &&
                    $name && ($phone || $email)) {

                    //добавление нового юзера
                    $user = Shop::Get()->getUserService()->addUserClient(
                        $name,
                        false,
                        false,
                        false,
                        false,
                        false,
                        $email,
                        $phone
                    );
                } else {
                    if (!$name) {
                        $ex->addError('name');
                        throw $ex;
                    }
                    if (!$email && !$phone) {
                        $ex->addError('contact');
                        throw $ex;
                    }
                }

                //метод добавления отзыва оторому передаются два параметра: отзыв и юзер
                Shop::Get()->getGuestBookService()->addGuestBook(
                    $response,
                    $user,
                    $orderNumber
                );
                $this->setValue('message', 'ok');
            } catch (ServiceUtils_Exception $ex) {
                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $ex->getErrorsArray());
            }
        }

        // вывод всех отзывов
        $guestbook = Shop::Get()->getGuestBookService()->getGuestBookAll();
        $guestbook->setOrder('cdate', 'DESC');
        $guestbook->addWhere('done', 0, '>');
        $guestbook->addWhere('text', '', '!=');
        $a = array();
        while ($g = $guestbook->getNext()) {
            $name = $g->getName();
            $login = "";
            $color = 'gray';

            try {
                $user = Shop::Get()->getUserService()->getUserByID($g->getUserid());

                if (!$name) {
                    $name = htmlspecialchars($user->getName());
                    $login = htmlspecialchars($user->getLogin());
                }

                $color = $user->makeColor();
            } catch (Exception $e) {

            }

            $a[] = array(
                'response' => nl2br(htmlspecialchars($g->getText())),
                'name' => $name,
                'login' => $login,
                'cdate' => $g->getCdate(),
                'color' => $color,
                'answer' => $g->getAnswer()
            );

        }
        $this->setValue('guestBookArray', $a);
    }

}