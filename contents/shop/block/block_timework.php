<?php
class block_timework extends Engine_Class {

    public function process() {
        // расписание работы магазина
        $currentTimework = Shop::Get()->getShopService()->getTimeworkCurrent();
        $currentTimeworkArray = array();
        while ($c = $currentTimework->getNext()) {
            $currentTimeworkArray[] = $c->getComment();
        }
        $this->setValue('currentTimeworkArray', $currentTimeworkArray);
    }

}