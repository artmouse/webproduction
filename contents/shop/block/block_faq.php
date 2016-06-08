<?php
class block_faq extends Engine_Class {

    public function process() {
        // последние вопросы
        try {
            $page = Shop::Get()->getTextPageService()->getTextPageByLogicclass('shop-faq');
            $url = $page->makeURL();

            $faq = Shop::Get()->getFaqService()->getFaqAll();
            $faq->addWhere('answer', '', '<>');
            $faq->setLimitCount(3);

            $a = array();
            while ($x = $faq->getNext()) {
                $color = 'gray';

                try {
                    $user = Shop::Get()->getUserService()->getUserByID($x->getUserid());
                    $color = $user->makeColor();
                } catch (Exception $e) {

                }

                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getQuestion(),
                'date' => DateTime_Formatter::DatePhonetic($x->getCdate()),
                'color' => $color
                );
            }
            $this->setValue('faqArray', $a);

            try {
                $page = Shop::Get()->getTextPageService()->getTextPageByLogicclass('shop-faq');
                $this->setValue('url', $page->makeURL());
            } catch (Exception $urlEx) {

            }
        } catch(Exception $e) {

        }
    }

}