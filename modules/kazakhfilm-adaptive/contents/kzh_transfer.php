<?php

class kzh_transfer extends Engine_Class {

    public function process() {

        try {
            $seo = SEOService::Get()->getSEOByURL('/transfer/');
            $this->setValue('seocontent', $seo->getSeocontent());
            Engine::GetHTMLHead()->setMetaDescription(htmlspecialchars($seo->getSeodescription()));
            Engine::GetHTMLHead()->setMetaKeywords(htmlspecialchars($seo->getSeokeywords()));
        } catch (Exception $e) {
            $this->setValue('seocontent', '');
            $this->setValue('seodescription', '');
            $this->setValue('seokeywords', '');
        }



        if ($this->getArgumentSecure('ok')) {

            $name = trim(strip_tags(($this->getControlValue('Name'))));
            $telephone = trim($this->getControlValue('Telephone'));

            $transfer = new XShopTransfer();
            $transfer->setName($name);
            $transfer->setTelephone($telephone);
            $transfer->insert();

            $subject = "Заказа трансфера";
            $text = "Здраствуйте!\n";
            $text .= "Посетитель ".$name.",\n";
            $text .="с номером телефона ".$telephone." ";
            $text .="хочет заказать услугу трансфера.\nНеобходимо ему перезвонить и узнать подробности.";
            $text .="\n\nСпасибо!";


            $letter = new MailUtils_Letter(
                'hotel-kazakhfilm@mail.ru',
                'hotel-kazakhfilm@mail.ru',
                $subject,
                $text
            );

            $letter->send();

            $this->setValue('message', 'ok');


        }


    }


}