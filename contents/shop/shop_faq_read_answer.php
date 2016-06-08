<?php
class shop_faq_read_answer extends Engine_Class {

    public function process() {
        $this->setValue('prevpage', Engine::GetURLParser()->getArgumentSecure('prev_page'));
        $id = $this->getArgumentSecure('id');
        if ($id) {
            try {
                $faq = Shop::Get()->getFaqService()->getFaqByID($id);
                $f = array();
                $f['name'] = Shop::Get()->getUserService()->getUserByID($faq->getUserid())->getName();
                $f['question'] = $faq->getQuestion();
                $f['answer'] = $faq->getAnswer();
                $f['cdate'] = $faq->getCdate();

                $this->setValue('f', $f);
            } catch (Exception $e) {
                Engine::Get()->getRequest()->setContentID('404');
            }
        }
    }

}