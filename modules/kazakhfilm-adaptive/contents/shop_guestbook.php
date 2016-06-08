<?php
class shop_guestbook extends Engine_Class {

    public function process() {
        Engine::GetHTMLHead()->setTitle('Отзывы');
        // добавление отзыва
        if ($this->getArgumentSecure('guestbook')) {
            try {
                if ($this->getControlValue('ajs') != 'ready') {
                    throw new ServiceUtils_Exception('bot');
                }

                Kazakh::Get()->getKazakhService()->addGuestBook(
                    $this->getControlValue('name'),
                    $this->getControlValue('email'),
                    $this->getControlValue('response')
                );

                $this->setValue('message', 'ok');
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('message', 'error');
                $this->setValue('errorArray', $e->getErrorsArray());

                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
        }


        // вывод всех отзывов
        $guestbook = Shop::Get()->getGuestBookService()->getGuestBookAll();
        $guestbook->setOrder('cdate', 'DESC');
        $guestbook->addWhere('done', 0, '>');
        $guestbook->addWhere('text', '', '!=');
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
                    'cdate' => $g->getCdate(),
                    'image' =>  $image
                );
            } catch (Exception $e) {

            }
        }
        $this->setValue('guestBookArray', $a);
    }

}