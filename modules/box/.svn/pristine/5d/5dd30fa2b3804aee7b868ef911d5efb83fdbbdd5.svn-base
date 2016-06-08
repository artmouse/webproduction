<?php
/**
 * Обработчик превращения письма в задачу
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class Box_Event_Email2Issue implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $email = $this->_getEvent($event);

        if ($email->getType() != 'email') {
            return;
        }

        // создание задач
        $event2issueArray = Engine::Get()->getConfigFieldSecure('project-box-event-to-issue');
        if (!$event2issueArray) {
            return;
        }

        if (empty($event2issueArray[$email->getTo()])) {
            return;
        }

        try {
            $tmp = $event2issueArray[$email->getTo()];
            $projectID = @$tmp['projectid'];
            $workflowID = @$tmp['workflowid'];
            $managerID = @$tmp['managerid']; // менеджер на которого назначится задача
            $authorID = @$tmp['authorid']; // автор задач на случай если контакт не опредеоен
            $checkOrder = @$tmp['checkorder'];
            $processor = @$tmp['processor'];

            if (!$authorID) {
                $authorID = $managerID;
            }

            $name = $email->getSubject();
            $content = $email->getContent();

            // @todo: что делать? создавать юзеров?
            try {
                $user = $email->getFromContact();
                $clientID = $user->getId();
            } catch (Exception $fromEx) {
                $user = Shop::Get()->getUserService()->getUserByID($authorID);
                $clientID = false;

                // дописываем email в контент
                $content .= "\n";
                $content .= $email->getFrom();
                if (!$name) {
                    $name = $email->getFrom();
                }
            }

            if (!$name) {
                $name = 'No subject';
            }

            $issue = false;
            if ($checkOrder && $clientID) {
                $checkOrderObjects = Shop::Get()->getShopService()->getOrdersAll(false, true);
                $checkOrderObjects->setUserid($clientID);
                $checkOrderObjects->setDateclosed('0000-00-00 00:00:00');
                $checkOrderObjects->setOrder('cdate', 'DESC');
                $checkOrderObjects->setLimitCount(1);
                $issue = $checkOrderObjects->getNext();
            }

            $fileIDArray = $email->getAttachmentFileIDArray();

            if (!$issue) {
                $issue = IssueService::Get()->addIssue(
                    $user,
                    $name,
                    $content,
                    $managerID,
                    $workflowID,
                    false, // due date
                    $clientID,
                    $projectID
                );

                // записываем email
                $issue->setClientemail($email->getFrom());
                $issue->update();

                // если есть обработчик - выполняем запуск
                if ($processor && class_exists($processor)) {
                    $processor = new $processor();
                    $processor->process($issue);
                }

                if ($fileIDArray) {
                    Shop::Get()->getShopService()->addOrderComment($issue, $user, '', $fileIDArray);
                }
            } else {
                $text = $name."\n";
                $text .= $content."\n";

                Shop::Get()->getShopService()->addOrderComment($issue, $user, $text, $fileIDArray);
            }

            // если все прошло успешно - то удаляем это письмо (событие)
            // issue #55659
            $email->setHidden(1);
            $email->update();
        } catch (Exception $issueEx) {
            print $issueEx;
        }
    }

    /**
     * Получить событие.
     * Метод оберта, используется чтобы IDE понимала правильную типизацию.
     *
     * @return ShopEvent
     */
    private function _getEvent(Events_Event $event) {
        return $event->getEvent();
    }

}