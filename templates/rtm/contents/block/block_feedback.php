<?php
class block_feedback extends Engine_Class {

      public function process() {
        // прием обратной связи
        if ($this->getArgumentSecure('feedback')) {
            try {
                if ($this->getControlValue('ajs') != 'ready') {
                    throw new ServiceUtils_Exception('bot');
                }

                try {
                    $user = $this->getUser();
                } catch (Exception $e) {
                    $user = Shop::Get()->getUserService()->addUserClient(
                    $this->getControlValue('fbname'),
                    false,
                    false,
                    $this->getControlValue('fbemail'),
                    $this->getControlValue('fbphone'),
                    false, // address
                    false, // company
                    false, // time
                    false, // comment admin
                    'feedback', // group type
                    $this->getControlValue('fbnamelast'),
                    $this->getControlValue('fbnamemiddle')
                    );
                }
                $fullname =  $this->getControlValue('fbnamelast')." ".$this->getControlValue('fbname')." ".$this->getControlValue('fbnamemiddle');
                Shop::Get()->getFeedbackService()->addFeedback(
                $fullname,
                $this->getControlValue('fbphone'),
                $this->getControlValue('fbemail'),
                $this->getControlValue('fbmessage'),
                $user
                );
                $this->setValue('feedbackmessage', 'ok');
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('feedbackmessage', 'error');
                $this->setValue('feedbackArray', $e->getErrorsArray());
            }
        }

        // заполняем по умолчанию данными форму feedback'a
        try {
            $u = $this->getUser();

            if (!$this->getValue('feedbackmessage')) {
                $this->setControlValue('fbname', $u->getName());
                $this->setControlValue('fbnamelast', $u->getNamelast());
                $this->setControlValue('fbnamemiddle', $u->getNamemiddle());
                $this->setControlValue('fbphone', $u->getPhone());
                $this->setControlValue('fbemail', $u->getEmail());
            }
        } catch (Exception $e) {

        }
    }

}