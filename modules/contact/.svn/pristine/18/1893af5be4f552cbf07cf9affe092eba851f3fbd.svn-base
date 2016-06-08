<?php

class users_permissions extends Engine_Class {

    public function process() {
        try {
            $user = Shop::Get()->getUserService()->getUserByID(
                $this->getArgument('id')
            );

            Engine::GetHTMLHead()->setTitle($user->makeName());

            if ($this->getControlValue('ok')) {
                try {
                    Shop::Get()->getUserService()->updateUserAuth(
                        $user,
                        $this->getControlValue('userlogin'),
                        $this->getControlValue('userpassword')
                    );

                    Shop::Get()->getUserService()->updateUserACL(
                        $user,
                        $this->getControlValue('level'),
                        $this->getControlValue('acl'),
                        $this->getControlValue('edate')
                    );

                    Shop::Get()->getUserService()->updateUserNotifications(
                        $user,
                        $this->getControlValue('notify_email_one'),
                        $this->getControlValue('notify_email_group'),
                        $this->getControlValue('notify_sms')
                    );

                    Shop::Get()->getUserService()->updateUserControlIP(
                        $user,
                        $this->getControlValue('controlip')
                    );

                    $user->setWorktimesystem($this->getControlValue('system_work_time'));
                    $user->setVoipblock(!$this->getControlValue('voip_block'));
                    $user->setNotificationblock(!$this->getControlValue('notification_block'));

                    $user->update();
                    
                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

            $acl = Shop::Get()->getAclService()->getACLPermissions(false);

            $a = array();
            $b = array();
            $id = 0;
            foreach ($acl as $x) {
                try {
                    $key = $x['key'];

                    $selected = $user->isAllowed($key, false);

                    $tmp = explode('::', $x['name']);
                    $tmpIndex = 0;
                    $pathArray = array();
                    foreach ($tmp as $xtmp) {
                        $xtmp = trim($xtmp);
                        if (!$xtmp) {
                            continue;
                        }
                        $tmpIndex++;
                        $pathArray[] = $xtmp;

                        $path = implode('/', $pathArray);

                        // это последний элемент?
                        $isLeaf = count($tmp) == $tmpIndex;

                        if (!isset($a[$path])) {
                            $parentPathArray = array_slice($pathArray, 0, count($pathArray) - 1);
                            $parentPath = implode('/', $parentPathArray);
                            $parentID = 0;
                            if (isset($a[$parentPath]['id'])) {
                                $parentID = $a[$parentPath]['id'];
                            }

                            $a[$path] = array(
                                'id' => $id,
                                'parentid' => $parentID,
                                'name' => $xtmp,
                                'level' => $tmpIndex - 1,
                                'key' => $isLeaf ? $key : false,
                                'selected' => $isLeaf ? $selected : false,
                            );

                            $id++;
                        }
                    }
                } catch (Exception $e) {

                }
            }

            foreach ($a as $aclItem) {
                if ($aclItem['parentid']) {
                    $b[$aclItem['parentid']][] = $aclItem;
                } else {
                    $b['parent'][] = $aclItem;
                }
            }


            if ($this->getControlValue('generatepassword')) {
                Shop::Get()->getUserService()->generateUserPassword($user);
            }

            $this->setValue('aclArray', $a);
            $this->setValue('newAclArray', $b);

            $this->setControlValue('userlogin', $user->getLogin());
            $this->setControlValue('edate', $user->getEdate());
            $this->setControlValue('level', $user->getLevel());
            $this->setControlValue('controlip', $user->getControlip());

            $this->setControlValue('notify_email_one', $user->getNotify_email_one());
            $this->setControlValue('notify_email_group', $user->getNotify_email_group());
            $this->setControlValue('notify_sms', $user->getNotify_sms());
            $this->setControlValue('system_work_time', $user->getWorktimesystem());
            $this->setControlValue('voip_block', !$user->getVoipblock());
            $this->setControlValue('notification_block', !$user->getNotificationblock());

            $menu = Engine::GetContentDriver()->getContent('shop-admin-users-menu');
            $menu->setValue('selected', 'permissions');
            $menu->setValue('userid', $user->getId());
            $this->setValue('menu', $menu->render());

            // список менеджеров для копирования прав
            $users = Shop::Get()->getUserService()->getUsersManagers();
            $a = array();
            while ($x = $users->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                );
            }
            $this->setValue('userArray', $a);

        } catch (Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}