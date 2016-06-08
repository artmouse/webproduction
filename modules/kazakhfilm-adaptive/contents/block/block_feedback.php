<?php
class block_feedback extends Engine_Class {

    public function process() {
        $guestbook = Shop::Get()->getGuestBookService()->getGuestBookAll();
        $guestbook->setOrder('cdate', 'DESC');
        $guestbook->addWhere('main', 0, '>');
        $guestbook->addWhere('text', '', '!=');
        $guestbook->setLimitCount(3);
        $a = array();
        while ($g = $guestbook->getNext()) {

            $image = Shop_ImageProcessor::MakeThumbUniversal(
                MEDIA_PATH.'/shop/'.$g->getImage(),
                100,
                100,
                'prop'
            );
            
            try {
                $a[] = array(
                    'response' => nl2br(htmlspecialchars($g->getText())),
                    'name' => $g->getName(),
                    'cdate' => DateTime_Formatter::DateRussianGOST($g->getCdate()),
                    'image' =>  $image
                );
            } catch (Exception $e) {

            }
        }
        $this->setValue('guestBookArray', $a);
    }

}