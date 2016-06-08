<?php
/**
 * Автоматические уведомления "необходимо перезвонить" и "у вас пропущенный звонок"
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_MissedCall {

    public function process() {
        $issueIDArray = array();

        // все сотрудники
        $employerIDArray = array(-1);
        $manager = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $manager->getNext()) {
            $employerIDArray[] = $x->getId();
        }

        // ищем все пропущенные звонки за последний день
        $calls = EventService::Get()->getEventsAll();
        $calls->setType('call');
        $calls->addWhereArray(array('CANCEL', 'BUSY'), 'status');
        $calls->addWhereArray($employerIDArray, 'touserid');
        $calls->setOrder('cdate', 'DESC');
        $calls->addWhere('cdate', DateTime_Object::Now()->addDay(-1)->__toString(), '>=');
        while ($x = $calls->getNext()) {

            try {
                $employer = $x->getToContact();
            } catch (Exception $e) {
                continue;
            }

            // проверка, был ли перезвон
            $tmp = new ShopEvent();
            $tmp->setType('call');
            $tmp->addWhere('cdate', $x->getCdate(), '>=');
            $tmp->setTo($x->getFrom());
            $tmp->setLimitCount(1);
            if ($xtmp = $tmp->getNext()) {
                continue;
            }

            try {
                $contactFrom = Shop::Get()->getUserService()->findUserByContact($x->getFrom(), 'call');

                // пропускаем самого себя
                if ($contactFrom->getId() == $employer->getId()) {
                    continue;
                }

                $text = 'Вам был звонок с номера '.$x->getFrom();
                $text .= ' - '.$contactFrom->makeName(false).'. Необходимо перезвонить.';

                try {
                    $issueID = NotifyService::Get()->addNotify(
                        $employer,
                        'missed-'.$x->getId(),
                        'Перезвонить '.$contactFrom->makeName(false),
                        $text,
                        $x->makeURL(),
                        false, // priority
                        $contactFrom->getId(), // clientID
                        false, // parentID
                        $contactFrom // author
                    );

                    $issueIDArray[] = $issueID;

                    // если задача была создана меньше 2х минут назад,
                    // то пытаемся отправить SMS
                    try {
                        $issue = IssueService::Get()->getIssueByID($issueID);
                        if (DateTime_Differ::DiffMinute(date('Y-m-d H:i:s'), $issue->getCdate()) <= 2) {
                            Shop::Get()->getUserService()->sendSMS(
                                $employer->getPhoneSMS(),
                                'Пропущенный звонок от '.$contactFrom->makeName().' '.$contactFrom->getPhone(),
                                $contactFrom
                            );
                        }
                    } catch (Exception $issueEx) {

                    }
                } catch (Exception $notifyEx) {

                }

            } catch (Exception $e) {
                // контакт не найден, создаем уведомление

                try {
                    $issueID = NotifyService::Get()->addNotify(
                        $employer,
                        'missed-'.$x->getId(),
                        'Перезвонить '.$x->getFrom(),
                        'Вам был звонок с неизвестного номера '.$x->getFrom().'. Необходимо перезвонить.',
                        $x->makeURL(),
                        false, // priority
                        0, // clientID
                        0 // parentID
                    );

                    $issueIDArray[] = $issueID;

                    // если задача была создана меньше 2х минут назад,
                    // то пытаемся отправить SMS
                    try {
                        $issue = IssueService::Get()->getIssueByID($issueID);
                        if (DateTime_Differ::DiffMinute(date('Y-m-d H:i:s'), $issue->getCdate()) <= 2) {
                            Shop::Get()->getUserService()->sendSMS(
                                $employer->getPhoneSMS(),
                                'Пропущенный звонок от неизвестного номера '.$x->getFrom()
                            );
                        }
                    } catch (Exception $issueEx) {

                    }
                } catch (Exception $notifyEx) {

                }
            }
        }

        return $issueIDArray;
    }

}