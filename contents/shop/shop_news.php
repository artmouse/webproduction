<?php
class shop_news extends Engine_Class {

    public function process() {
        // новости
        $news = Shop::Get()->getNewsService()->getNewsAll();
        $news->setHidden(0);
        $a = array();
        while ($x = $news->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            'contentPreview' => $x->getContentpreview(),
            'image' => $x->makeImageThumb(150, 150, 'crop'),
            'date' => DateTime_Formatter::DatePhonetic($x->getCdate()),
            'url' => $x->makeURL(),
            );
        }
        $this->setValue('newsArray', $a);
    }

}