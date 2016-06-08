<?php
/**
 * Обработчик входящих писем на емейл box@...
 * Добавляет email-комментарий в задачу или создает новую задачу.
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 *
 * @copyright WebProduction
 * 
 * @package OneBox
 */
class Box_Event_EmailBoxParser implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $email = $this->_getEvent($event);

        if ($email->getType() != 'email') {
            return;
        }

        // для новых писем
        $boxParser = Shop::Get()->getSettingsService()->getSettingValue('box-parser-email');
        if (!$boxParser) {
            return;
        }

        // если в теме есть номер #XXXXX
        if (preg_match("/\#(\d+)/ius", $email->getSubject(), $r)) {
            try {
                $order = Shop::Get()->getShopService()->getOrderByID($r[1]);

                $comment = false;
                if (preg_match("/^(.+?)\-\-\-\-\-\-\-\-\-\-/ius", $email->getContent(), $r1)) {
                    $comment = trim($r1[1]);
                } else {
                    $comment = $email->getContent();
                }
                if (!$comment) {
                    throw new ServiceUtils_Exception();
                }

                // откуда идет письмо
                try {
                    $userFrom = Shop::Get()->getUserService()->findUserByContact(
                        $email->getFrom(),
                        'email'
                    );
                    $userFromEmployer = $userFrom->getEmployer();
                } catch (Exception $e) {
                    // технически userfrom может не быть
                    $userFrom = false;
                    $userFromEmployer = false;
                }

                // проверка, на какой ящик пришло письмо.
                // Если это box@ - то парсим.
                // Иначе если письмо пришло от клиента - то тоже парсим.
                if ($boxParser != $email->getTo()
                && !$userFromEmployer) {
                    throw new ServiceUtils_Exception();
                }

                // если задача закрыта, то открываем ее
                /*if ($order->isClosed()) {
                    try {
                        $userFromTmp = $userFrom;
                        if (!$userFromTmp) {
                            $userFromTmp = $order->getAuthor();
                        }

                        Shop::Get()->getShopService()->updateOrderStatus(
                            $userFromTmp,
                            $order,
                            $order->getWorkflow()->getStatusDefault()->getId()
                        );
                    } catch (Exception $openEx) {

                    }
                }*/

                // вложенные файлы в письмо
                $fileIDArray = $email->getAttachmentFileIDArray();

                // добавляем письмо
                Shop::Get()->getShopService()->addOrderEmail(
                    $order,
                    $userFrom,
                    $comment,
                    $fileIDArray
                );

                // если все прошло успешно - то удаляем это письмо (событие)
                // issue #55659
                $email->setHidden(1);
                $email->update();
            } catch (Exception $orderEx) {
                print $orderEx;
            }
        } elseif ($boxParser == $email->getTo()) {
            $found = false;

            // в теме не было номера - значит создавать задачу на сотрудника,
            // если есть такой юзер с таким емейлом и он активен
            try {
                $userFrom = Shop::Get()->getUserService()->findUserByContact($email->getFrom(), 'email');
                if ($userFrom->getEmployer()) {
                    // создаем задачу на самого себя
                    $issue = IssueService::Get()->addIssue(
                        $userFrom,
                        $email->getSubject(),
                        $email->getContent(),
                        $userFrom->getId(),
                        false // default category for issue
                    );

                    // вложенные файлы в письмо
                    $fileIDArray = $email->getAttachmentFileIDArray();

                    // добавляем файлы
                    if ($fileIDArray) {
                        Shop::Get()->getShopService()->addOrderComment(
                            $issue,
                            $userFrom,
                            '', // content
                            $fileIDArray
                        );
                    }

                    // если все прошло успешно - то удаляем это письмо (событие)
                    // issue #55659
                    $email->setHidden(1);
                    $email->update();

                    $found = true;
                }
            } catch (Exception $notifyEx) {
                $userFrom = false;
            }

            // если письмо не запарсилось потому что оно не на сотрудника,
            // то передаем его в support
            if (!$found) {
                try {
                    // в какой проект
                    $unknownProjectID = Shop::Get()->getSettingsService()->getSettingValue(
                        'box-parser-email-projectid'
                    );

                    // и на кого назначать такие письма
                    $unknownManagerID = Shop::Get()->getSettingsService()->getSettingValue(
                        'box-parser-email-managerid'
                    );

                    $unknownWorkflowID = Shop::Get()->getSettingsService()->getSettingValue(
                        'box-parser-email-workflowid'
                    );

                    if (!$unknownProjectID || !$unknownManagerID) {
                        throw new ServiceUtils_Exception();
                    }

                    if (!$userFrom) {
                        $userFrom = Shop::Get()->getUserService()->getUserByID($unknownManagerID);
                        $clientID = false;
                    } else {
                        $clientID = $userFrom->getId();
                    }

                    $issue = IssueService::Get()->addIssue(
                        $userFrom,
                        $email->getSubject(),
                        $email->getContent(),
                        $unknownManagerID,
                        $unknownWorkflowID,
                        false, // due date
                        $clientID,
                        $unknownProjectID
                    );

                    // вложенные файлы в письмо
                    $fileIDArray = $email->getAttachmentFileIDArray();

                    // записываем email
                    $issue->setClientemail($email->getFrom());
                    $issue->update();

                    // добавляем файлы
                    if ($fileIDArray) {
                        Shop::Get()->getShopService()->addOrderComment(
                            $issue,
                            $userFrom,
                            '', // content
                            $fileIDArray
                        );
                    }
                } catch (Exception $e) {

                }
            }
        }
    }

    /**
     * Метод-обертка для получение правильного типа ShopEvent
     *
     * @return ShopEvent
     */
    private function _getEvent(Events_Event $event) {
        return $event->getEvent();
    }

}