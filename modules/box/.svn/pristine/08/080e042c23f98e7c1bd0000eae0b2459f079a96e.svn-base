<?php
class voip_call extends Engine_Class {

    public function process() {
        try {
            
            if ($this->getUser()->getVoipblock()) {
                // не показывать блок
                return;
            }

            $found = false;
            $clientID = false;

            $phoneMyArray = $this->getUser()->getPhoneArray();
            if (!$phoneMyArray) {
                exit();
            }

            // входящие звонки
            $calls = new XShopUserVoIP();
            $calls->addWhereArray($phoneMyArray, 'to');
            $calls->addWhere('from', '', '<>');
            $calls->setClosed(0);
            $calls->setLimitCount(1);
            if ($x = $calls->getNext()) {
                // есть звонок
                $callerID = $x->getFrom();
                if ($callerID) {
                    $this->setValue('callID', $x->getId());

                    try {
                        $contact = Shop::Get()->getUserService()->findUserByContact($callerID, 'call');

                        // контакт найден

                        $block = Engine::GetContentDriver()->getContent('voip-call-contact');
                        $block->setValue('contact', $contact);
                        $this->setValue('block_contact', $block->render());

                        $this->setValue('direction', 'in');
                        $found = true;
                    } catch (Exception $e) {
                        // контакт не найден

                        $this->setValue('phone', $callerID);

                        $this->setValue('direction', 'in');
                        $usersGroups = Shop::Get()->getUserService()->getUsersGroups();
                        $this->setValue('groupArray', $usersGroups);
                        $found = true;
                    }
                }
            }

            if (!$found) {
                // анализируем мои исходящие звонки
                $calls = new XShopUserVoIP();
                $calls->addWhereArray($phoneMyArray, 'from');
                $calls->setClosed(0);
                $calls->setLimitCount(1);
                if ($x = $calls->getNext()) {
                    // кому я звоню?
                    $to = $x->getTo();

                    $this->setValue('callID', $x->getId());

                    try {
                        $contact = Shop::Get()->getUserService()->findUserByContact($to, 'call');
                        $clientID = $contact->getId();

                        // контакт найден

                        $block = Engine::GetContentDriver()->getContent('voip-call-contact');
                        $block->setValue('contact', $contact);
                        $this->setValue('block_contact', $block->render());

                        $this->setValue('direction', 'out');
                        $found = true;
                    } catch (Exception $e) {
                        // контакт не найден - не ясно кому я звоню

                        $this->setValue('phone', $to);

                        $this->setValue('direction', 'out');
                        $found = true;
                    }
                }
            }

            // Список бизнес-процессов
            $category = Shop::Get()->getShopService()->getWorkflowsActive($this->getUser());
            $a = array();

            $dynamicWorkflow = false;
            if (Shop_ModuleLoader::Get()->isModuleInModulesArray('box')
                && !Engine::Get()->getConfigFieldSecure('static-shop-menu')
            ) {
                $dynamicWorkflow = true;
            }

            while ($x = $category->getNext()) {
                $p = array();
                $p['workflowid'] = $x->getId();

                if ($found && $contact && get_class($contact) == "User") {
                    $p['clientid'] = $contact->getId();
                    $p['clientname'] = urlencode($contact->makeName());
                }


                $typeWorkflow = $x->getType();
                if (!$typeWorkflow) {
                    $typeWorkflow = 'order';
                }

                if ($dynamicWorkflow) {
                    $url = '/admin/customorder/'.$typeWorkflow.'/add/';
                    if ($x->getType()) {
                        try{
                            $typeObj = new XShopWorkflowType();
                            $typeObj->setType($x->getType());
                            $typeObj = $typeObj->getNext();
                            if ($typeObj && $typeObj->getContentId()) {
                                $content = Engine_ContentDriver::Get()->getContent(
                                    $typeObj->getContentId()
                                )->getContentData();
                                if ($content['url']) {
                                    $url = $content['url'];
                                }
                            }
                        } catch (Exception $econten) {

                        }
                    }
                } else {
                    $url = '/admin/'.$typeWorkflow.'/add/';
                }

                $url .= '?';

                foreach ($p as $foreachKey => $foreachValue) {
                    if (!$foreachKey || !$foreachValue) {
                        continue;
                    }
                    $url.=$foreachKey.'='.$foreachValue.'&';
                }


                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                    'url' => $url,
                );
            }
            $this->setValue('workflowArray', $a);

            if (!$found) {
                // ускоренный выход
                exit();
            }
        } catch (Exception $ge) {
            // ускоренный выход
            exit();
        }
    }

}