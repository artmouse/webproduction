<?php

class user_worktime extends Engine_Class {

    public function process() {
        
        try {
            $user = Shop::Get()->getUserService()->getUserByID(
                $this->getArgument('id')
            );
            $this->setValue('clientid', $this->getArgument('id'));
            $userID = $user->getId();
            if (!Shop::Get()->getUserService()->isUserChangeAllowed($user, $this->getUser())) {
                throw new ServiceUtils_Exception('user-permission');
            }



            if ($this->getArgumentSecure('addCheck')) {            
                $checkbox = $this->getArgumentSecure('checkActives', 'array');

                try {
                    SQLObject::TransactionStart();

                    // получаем массив всех чекбоксов по данному юзеру
                    $work = new XShopUserWorkTime();
                    $work->setUserid($userID);
                    $a = array();
                    while ($x = $work->getNext()) {
                        $a[$x->getId()] = $x;
                    }
                    foreach ($checkbox as $check) {
                        try {
                            $tmp = new XShopUserWorkTime();
                            $tmp->setUserid($userID);
                            $tmp->setCdate($check);
                            if (!$tmp->select()) {
                                $tmp->insert();
                            }

                            // если обновили - убираем из массива
                            if (isset($a[$tmp->getId()])) {
                                unset($a[$tmp->getId()]);
                            }
                        } catch (Exception $e) {

                        }
                    }
                    foreach ($a as $id => $object) {
                        $object->delete();
                    }
                    SQLObject::TransactionCommit();
                } catch (Exception $ge) {
                    SQLObject::TransactionRollback();
                    throw $ge;
                }

            }

            Engine::GetHTMLHead()->setTitle($user->makeName());

            $menu = Engine::GetContentDriver()->getContent('shop-admin-users-menu');
            $menu->setValue('selected', 'worktime');
            $menu->setValue('userid', $userID);
            $this->setValue('block_menu', $menu->render());

            $this->setValue('userid', $userID);

            $dateFrom = date('Y-m-d', strtotime('Mon this week')); 
            $dateTo = date('Y-m-d', strtotime('Mon next week')); 

            if ($this->getArgumentSecure('ok')) {
                $dateFrom = $this->getArgumentSecure('datefrom', 'date');
                $dateTo = $this->getArgumentSecure('dateto', 'date');
                $dateTo = DateTime_Object::FromString($dateTo);
                $dateTo = $dateTo->preview();
            }

            $d = DateTime_Object::FromString($dateFrom)->setFormat('Y-m-d H:i');
            $dateArray = false;
            $timeArray = false;

            while ($d->__toString() <= $dateTo) {
                $dateCurrent = $d->preview('Y-m-d');
                $dateArray [] = $dateCurrent;
                for ($i = 0; $i < 24; $i++) {
                    if ($i < 10) {
                        $timeArray ["0" . $i . ":00"][$dateCurrent] = 0;
                    } else {
                        $timeArray [$i . ":00"][$dateCurrent] = 0;
                    }
                }
                $d->addDay(+1);
            }

            $worktime = new XShopUserWorkTime();
            $worktime->setUserid($userID);
            $worktime->addWhere('cdate', $dateFrom, '>=');
            $worktime->addWhere('cdate', $dateTo, '<=');

            while ($w = $worktime->getNext()) {
                $cdate = $w->getCdate();
                $cdate = explode(' ', $cdate);
                $cdate[1] = substr($cdate[1], 0, 5);
                $timeArray[$cdate[1]][$cdate[0]] = 1;
            }

            $this->setValue('timeArray', $timeArray);
            $this->setValue('dateArray', $dateArray);       
        } catch (Exception $ex) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }
            $this->setValue('message', $ex->getMessage());
            return;
        }

    }
}