<?php
class voip_call_contact_edit_phone extends Engine_Class {

    public function process() {
        $contact = $this->getValue('contact');

        if ($this->getArgumentSecure('edit')) {
            try {

                $phones = trim($this->getArgumentSecure('phone'));
                $phones = str_replace(",", "\n", $phones);
                $phoneArray = explode("\n", $phones);
                $phone = trim($phoneArray[0]);
                unset($phoneArray[0]);
                $phones = implode("\n", $phoneArray);
                $phones = trim($phones);
                $phones = str_replace(",", "\n", $phones);
                $phones = str_replace(" ", '', $phones);

                $contact = Shop::Get()->getUserService()->getUserByID($this->getArgumentSecure('userid'));

                $contact->setPhone($phone);
                $contact->setPhones($phones);
                $contact->update();

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