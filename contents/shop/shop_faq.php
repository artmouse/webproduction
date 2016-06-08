<?php
class shop_faq extends Engine_Class {

    public function process() {
        Engine::GetHTMLHead()->setTitle(Shop::Get()->getTranslateService()->getTranslateSecure('translate_faq'));

        $this->setValue('isUserAuthorized', $this->isUserAuthorized());

        // добавление вопроса
        if ($this->getArgumentSecure('faq')) {
            try {
                if ($this->getControlValue('ajs') != 'ready') {
                    throw new ServiceUtils_Exception('bot');
                }

                Shop::Get()->getFaqService()->addFaq(
                    $this->getArgument('question'),
                    $this->getUser()->getId()
                );

                $this->setValue('message', 'ok');
            } catch (Exception $e) {
                $this->setValue('message', 'error');

                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
        }

        // список всех FAQ
        $faq = Shop::Get()->getFaqService()->getFaqAll();
        $faq->addWhere('answer', '', '!=');
        $a = array();
        while ($f = $faq->getNext()) {
            try {
                $user = Shop::Get()->getUserService()->getUserByID($f->getUserid());

                $a[] = array(
                    'id' => $f->getId(),
                    'answer' => nl2br(htmlspecialchars($f->getAnswer())),
                    'question' => nl2br(htmlspecialchars($f->getQuestion())),
                    'name' => $user->getName() ? $user->getName() : $user->getLogin(),
                    'cdate' => $f->getCdate(),
                    'prevPage' => Engine::GetURLParser()->getCurrentURL(),
                    'color' => $user->makeColor()
                );
            } catch (Exception $e) {

            }
        }
        $this->setValue('faqArray', $a);
    }

}