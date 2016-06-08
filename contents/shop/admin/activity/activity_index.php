<?php
class activity_index extends Engine_Class {

    public function process() {
        $datefrom = $this->getArgumentSecure('datefrom');
        $dateto = $this->getArgumentSecure('dateto');
        $userID = $this->getArgumentSecure('user');

        if (Checker::CheckDate($datefrom)) {
            $datefrom = DateTime_Corrector::CorrectDate($datefrom).' 00:00:00';
        } else {
            $datefrom = DateTime_Object::Now()->addDay(-1)->__toString();
        }
        if (Checker::CheckDate($dateto)) {
            $dateto = DateTime_Corrector::CorrectDate($dateto).' 23:59:59';
        } else {
            $dateto = DateTime_Object::Now()->addDay(0)->__toString();
        }

        $comments = CommentsAPI::Get()->getComments();
        $comments->addWhere('cdate', $datefrom, '>=');
        $comments->addWhere('cdate', $dateto, '<=');
        $comments->addWhere('key', 'shop-history%', 'LIKE');
        if ($userID) {
            $comments->setId_user($userID);
        }
        $comments->setOrder('cdate', 'DESC');
        $a = array();
        $b = array();
        $c = array();
        while ($x = $comments->getNext()) {
            try {
                $user = Shop::Get()->getUserService()->getUserByID($x->getId_user())->makeInfoArray();
            } catch (Exception $e) {
                $user = array();
            }

            $content = $x->getContent();
            $content = nl2br(htmlspecialchars($content));

            $date = DateTime_Formatter::DateRussianGOST($x->getCdate());

            $a[$date][] = array(
            'time' => DateTime_Formatter::TimeISO8601($x->getCdate()),
            'content' => $content,
            'user' => $user,
            );

            @$b[$user['id']] ++;
            @$c[$user['id']] = $user;
        }
        $this->setValue('activityArray', $a);
        $this->setValue('activitySummaryArray', $b);
        $this->setValue('usersArray', $c);

        // список пользователей
        $users = Shop::Get()->getUserService()->getUsersManagers($this->getUser());
        $users->addWhere('level', 2, '>=');
        $a = array();
        while ($x = $users->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'login' => $x->getLogin(),
            );
        }
        $this->setValue('filterUsersArray', $a);
    }

}