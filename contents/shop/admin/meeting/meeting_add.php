<?php
class meeting_add extends Engine_Class {

    public function process() {
        if ($this->getArgumentSecure('ok') || $this->getArgumentSecure('okClear')){
            try {
                $toArray = explode(',', $this->getArgumentSecure('to'));
                if (!$toArray) {
                    throw new ServiceUtils_Exception();
                }
                $date = $this->getArgument('date', 'datetime');
                if (!$date) {
                    throw new ServiceUtils_Exception();
                }
                $content = $this->getControlValue('content');
                $location = $this->getControlValue('location');
                try {
                    $from = Shop::Get()->getUserService()->getUserByID(
                    $this->getArgument('from')
                    );
                } catch (Exception $e) {
                    $from = $this->getUser();
                }

                foreach ($toArray as $toID) {
                    try {
                        SQLObject::TransactionStart();

                        $event = new ShopEvent();
                        $event->setType('meeting');
                        $event->setFrom('contact-'.$from->getId());
                        $event->setTo('contact-'.$toID);
                        $event->setCdate($date);
                        $event->setContent($content);
                        $event->setLocation($location);
                        $event->insert();
                       
                        EventService::Get()->processEventParameters($event);

                        if ($this->getArgumentSecure('send')) {
                            try {
                                $contactTo = Shop::Get()->getUserService()->getUserByID($toID);

                                $text = '';
                                $text .= $contactTo->makeName(false, false).'!'."\n";
                                $text .= "\n";
                                $text .= "{$from->makeName(false, false)} приглашает Вас на встречу.\n";
                                $text .= "Дата и время: {$date}\n";
                                $text .= "Место проведения: {$location}\n";
                                $text .= "Примечание: {$content}\n";

                                // отправляем уведомление
                                $subject = '';
                                try {
                                    $subject .= Engine::Get()->getConfigField('project-branding').' ';
                                } catch (Exception $nameEx) {

                                }
                                $subject .= 'Metting '.$date;

                                if ($contactTo->getEmail()) {
                                    $letter = new MailUtils_Letter($from->getEmail(), $contactTo->getEmail(), $subject, $text);
                                    $letter->send();
                                }
                            } catch (Exception $mailEx) {

                            }
                        }

                        SQLObject::TransactionCommit();
                    } catch (Exception $ge) {
                        SQLObject::TransactionRollback();
                    }
                }
                //получить id последней записи ивента
                 $id_event =  $event->getId();
                //контроль редиректа
                 $redirect_controll = true;

                $this->setValue('message', 'ok');
                if ($this->getControlValue('okClear')){
                    $this->setValue('value','clear');
                }

            } catch (Exception $e) {
                $this->setValue('message', 'error');
                $redirect_controll = false;//если неправильно заполнены поля, задать блокирование редиректа
            }
        } else {
            $this->setControlValue('from', $this->getUser()->getId());
        }
        //контрольные значения
        $toArray = explode(',', $this->getArgumentSecure('to'));
        $usertoArray = array();
        foreach ($toArray as $clientID) {
            try {
                $client = Shop::Get()->getUserService()->getUserByID($clientID);
                
                $usertoArray[] = array(
                'id' => $clientID,
                'text' => $client->makeName()
                );
            } catch (ServiceUtils_Exception $pe) {

            }
        }
        
        $this->setValue('usertoArray', $usertoArray);

        // вывод данных
        $contacts = Shop::Get()->getUserService()->getUsersAll();
        $contacts->addWhere('typesex', 'company', '!=');
        $a = array();
        while ($x = $contacts->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            );
        }
        $this->setValue('contactArray', $a);

        $a = $this->getArgumentSecure('to', 'array');
        $this->setValue('toArray', $a);
        //уходим на карточку созданной встречи
        if ($this->getArgumentSecure('ok') && $redirect_controll) {
            $this->setValue('urlredirect', "/admin/meeting/$id_event/");
        }
    }
        
}