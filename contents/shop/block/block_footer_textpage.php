<?php
class block_footer_textpage extends Engine_Class {

    public function process() {
        $pageArray = Shop::Get()->getTextPageService()->getTextPageArray();
        $a = array();
        foreach ($pageArray as $x) {
            if ($x->getParentid() || $x->getHidden()) {
                continue;
            }

            if ($x->getBtnname()) {
                $a[] = array(
                    'name' => $x->getBtnname(),
                    'url' => $x->makeURL(),
                );
            }
        }
        $this->setValue('textpageArray', $a);
    }

}