<?php
class kzh_contacts extends Engine_Class {

    public function process() {

        try {
            $seo = SEOService::Get()->getSEOByURL('/contacts/');
            $this->setValue('seocontent', $seo->getSeocontent());
            Engine::GetHTMLHead()->setMetaDescription(htmlspecialchars($seo->getSeodescription()));
            Engine::GetHTMLHead()->setMetaKeywords(htmlspecialchars($seo->getSeokeywords()));
        } catch (Exception $e) {
            $this->setValue('seocontent', '');
            $this->setValue('seodescription', '');
            $this->setValue('seokeywords', '');
        }

         PackageLoader::Get()->registerJSFile('https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true');
         $phones = Shop::Get()->getSettingsService()->getSettingValue('header-phone');
         $phones = explode(',', $phones);
         $cnt = count($phones);

        for ($i = 1; $i< $cnt+1;$i++) {

            $this->setValue("phone$i", $phones[$i-1]);

        }

         $this->setValue('email', Shop::Get()->getSettingsService()->getSettingValue('header-email'));
          $this->setValue('skype', Shop::Get()->getSettingsService()->getSettingValue('header-skype'));
    }

}