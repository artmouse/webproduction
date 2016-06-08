<?php
class contacts extends Engine_Class {

    public function process() {
        //title page
        $settings = new XShopSettings;
        $settings->setKey('page-contact-company-name');
        $title = $settings->getNext();
        $title = $title->getValue();
        $title = 'Контакты | Интернет-магазин "Ремточмеханика"';
        Engine::GetHTMLHead()->setTitle($title);
        Engine::GetHTMLHead()->setMetaKeywords('контакты, киев, интернет-магазин, ремточмеханика');
        Engine::GetHTMLHead()->setMetaDescription('Хотите связаться с нами и задать вопросы - звоните (044) 248-65-69. Или воспользуйтесь контактными данными на этой странице.');

        // настройки
        $phones = Shop::Get()->getSettingsService()->getSettingValue('header-phone');
        $phones = explode(',',$phones);
        shuffle($phones);
        for ($i = 1;$i< count($phones)+1;$i++){
            $this->setValue("phone$i",$phones[$i-1] );
        }

        $this->setValue('email', Shop::Get()->getSettingsService()->getSettingValue('header-email'));
        $this->setValue('address', Shop::Get()->getSettingsService()->getSettingValue('company-address'));
        $this->setValue('worktime', Shop::Get()->getSettingsService()->getSettingValue('work-time'));
        $this->setValue('istat_span_2', Shop::Get()->getSettingsService()->getSettingValue('code-istat-span-2'));
//        //title content
//        $settings = new XShopSettings();
//        $settings->setKey('page-contact-company');
//        $content = $settings->getNext();
//        $content = $content->getValue();
//        $this->setValue('content', $content);

    }

}