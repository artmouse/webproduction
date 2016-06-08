<?php
/**
 * Обработчик превращения звонка в задачу
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class Box_Event_Call2Issue implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $call = $this->_getEvent($event);

        if ($call->getType() != 'call') {
            return;
        }

        // пропускаем внутренние звонки
        try {
            if ($call->getFromContact()->getEmployer()) {
                return;
            }
        } catch (Exception $e) {

        }

        // создание задач
        $event2issueArray = Engine::Get()->getConfigFieldSecure('project-box-event-to-issue');
        if (!$event2issueArray) {
            return;
        }

        if (empty($event2issueArray[$call->getTo()])) {
            return;
        }

        try {
            $tmp = $event2issueArray[$call->getTo()];
            $projectID = @$tmp['projectid'];
            $workflowID = @$tmp['workflowid'];
            $managerID = @$tmp['managerid']; // менеджер на которого назначится задача
            $authorID = @$tmp['authorid']; // автор задач на случай если контакт не опредеоен
            $checkOrder = @$tmp['checkorder'];
            $processor = @$tmp['processor'];

            if (!$authorID) {
                $authorID = $managerID;
            }

            // @todo: что делать? создавать юзеров?
            try {
                $user = $call->getFromContact();
                $clientID = $user->getId();
                $clientName = $user->makeName(false);
            } catch (Exception $fromEx) {
                $user = Shop::Get()->getUserService()->getUserByID($authorID);
                $clientID = false;
                $clientName = $call->getFrom();
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

            $subject = 'Звонок от '.$clientName;
            $content = "Звонок #{$call->getId()} от {$call->getCdate()} на линию {$call->getSession()}";

            // проверка, может за последние N часов уже были обращения от этого номера
            if (!$issue) {
                $checkOrderObjects = Shop::Get()->getShopService()->getOrdersAll(false, true);
                $checkOrderObjects->setName($subject);
                $checkOrderObjects->addWhere('cdate', DateTime_Object::Now()->addHour(-8)->__toString(), '>=');
                $checkOrderObjects->setDateclosed('0000-00-00 00:00:00');
                $checkOrderObjects->setOrder('cdate', 'DESC');
                $checkOrderObjects->setLimitCount(1);
                $issue = $checkOrderObjects->getNext();
            }

            if (!$issue) {
                $issue = IssueService::Get()->addIssue(
                    $user,
                    $subject,
                    $content,
                    $managerID,
                    $workflowID,
                    false, // due date
                    $clientID,
                    $projectID
                );
            } else {
                $text = $subject."\n";
                $text .= $content."\n";

                Shop::Get()->getShopService()->addOrderComment($issue, $user, $text);
            }

            // для звонков не надо
            /*// если все прошло успешно - то удаляем этот звонок (событие)
            // issue #55659
            $call->setHidden(1);
            $call->update();*/
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