<?php
class voip_call_contact extends Engine_Class {

    public function process() {
        $contact = $this->getValue('contact');

        if (!$contact) {
            try {
                $nameFirst = $this->getArgument('namefirst');
                $nameLast = $this->getArgument('namelast');
                $nameMiddle = $this->getArgument('namemiddle');
                $company = $this->getArgument('company');
                $source = $this->getArgumentSecure('source');
                $title = $this->getArgument('title');
                $typesex = $this->getArgument('typesex');
                $groupid = $this->getArgumentSecure('groupid');
                $phone = $this->getArgument('phone');

                $contact = Shop::Get()->getUserService()->addUserClient(
                    $nameFirst,
                    $nameLast,
                    $nameMiddle,
                    $typesex,
                    $company,
                    $title,
                    false, // email
                    $phone
                );
                if ($source) {
                    try{
                        $sourceObject = Shop::Get()->getShopService()->getSourceByAddress($source);
                    } catch (Exception $e) {
                        $sourceObject = Shop::Get()->getShopService()->addSource($source, $source);
                    }
                    $contact->setSourceid($sourceObject->getId());
                    $contact->update();
                }

                if ($groupid) {
                    try{
                        Shop::Get()->getUserService()->addUserToGroup(
                            $contact,
                            Shop::Get()->getUserService()->getUserGroupByID($groupid)
                        );
                    } catch (Exception $egroup) {

                    }
                }

            } catch (Exception $contactEx) {

            }
        }

        $this->_makeContactInfo($contact);

        // список бизнес-процессов
        $workflow = Shop::Get()->getShopService()->getWorkflowsActive(
            $this->getUser()
        );
        $a = array();
        while ($x = $workflow->getNext()) {
            $p = array();
            $p['workflowid'] = $x->getId();
            $p['clientid'] = $contact->getId();
            $p['clientname'] = $contact->makeName();

            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->getName(),
            'url' => Engine::GetLinkMaker()->makeURLByContentIDParams('issue-add', $p),
            );
        }
        $this->setValue('workflowArray', $a);
    }

    private function _makeContactInfo(User $contact) {
        $this->setValue('contactID', $contact->getId());
        $this->setValue('phoneArray', $contact->getPhoneArray());
        $this->setValue('emailArray', $contact->getEmailArray());
        $this->setValue('name', $contact->makeName());
        $this->setValue('url', $contact->makeURLEdit());
        $this->setValue('tags', $contact->getTags());
        $this->setValue('avatar', $contact->makeImageThumb(200));

        try {
            $this->setValue('managerName', $contact->getManager()->makeName());
            $this->setValue('managerURL', $contact->getManager()->makeURLEdit());
            $this->setValue('managerID', $contact->getManager()->getId());
        } catch (Exception $managerEx) {

        }

        // последние N заказов клиента
        $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
        $orders->setUserid($contact->getId());
        $orders->setOrder('cdate', 'DESC');
        $orders->setLimitCount(3);
        $a = array();
        while ($x = $orders->getNext()) {
            try {
                $a[] = array(
                'name' => $x->makeName(),
                'url' => $x->makeURLEdit(),
                'sum' => $x->getSum(),
                'currency' => $x->getCurrency()->getName(),
                'status' => $x->getStatus()->makeName(),
                );
            } catch (Exception $orderEx) {

            }
        }
        $this->setValue('orderArray', $a);
    }

}