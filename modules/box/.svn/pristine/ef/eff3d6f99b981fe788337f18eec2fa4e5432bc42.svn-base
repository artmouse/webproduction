<?php
class admin_report_massemailsend extends Engine_Class {

    public function process() {
        
        $dateFrom = $this->getArgumentSecure('datefrom');
        $dateTo = $this->getArgumentSecure('dateto');

        $mails = new MailUtils_XQue();
        $mails->setGroupByQuery('cdate');
        if ($dateFrom) {
            $dateFrom = DateTime_Object::FromString($dateFrom)->setFormat('Y-m-d')->__toString();
            $mails->addWhere('cdate', $dateFrom, '>=');          
        }
        if ($dateTo) {
            $dateTo = DateTime_Object::FromString($dateTo)->setFormat('Y-m-d')->__toString();
            $mails->addWhere('cdate', $dateTo.' 23:59:59', '<=');
        }

        while ($m = $mails->getNext()) {
            
            $a[] = array (
                'cdate' => $m->getCdate(),
                'status' => $m->getStatus(),
                'sdate' => $m->getSdate(),
                'about' => $m->getFrom(),
                'theme' => $m->getSubject(),
            );
        }
        $this->setValue('arrayMailsSend', $a);
    }

}