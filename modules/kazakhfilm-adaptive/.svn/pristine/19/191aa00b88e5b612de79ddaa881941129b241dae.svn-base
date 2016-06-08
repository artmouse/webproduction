<?php
class shop_index extends Engine_Class {

    public function process() {
        // SEO текст на главную
        try {
            $this->setValue(
                'seotextinindexpage',
                Shop::Get()->getSettingsService()->getSettingValue('seo-text-in-index-page')
            );
        } catch (Exception $e) {

        }

        $gallery = GalleryService::Get()->getGalleryActive();
        $a = array();
        $gallery->setOrder('sort', 'ASC');
        while ($x = $gallery->getNext()) {
            $a[] = array(
                'name' => $x->makeName(),
                'image' => str_replace(
                    PackageLoader::Get()->getProjectPath(),
                    '',
                    Shop_ImageProcessor::MakeThumbCrop(
                        PackageLoader::Get()->getProjectPath().'/media/shop/'.$x->getImage(), 300, 200, 'png'
                    )
                ),
                'content_item' => explode(';', trim(strip_tags($x->getContent())))
            );
        }
        $this->setValue('galleryArray', $a);


        if ($this->getArgumentSecure('ok')) {

            $this->setValue('callmessage', 'ok');

            try {
                $user = $this->getUser();
            } catch (Exception $e) {
                    $user = Shop::Get()->getUserService()->addUserClient(
                        $this->getControlValue('cbname'),
                        false,
                        false,
                        false,
                        $this->getControlValue('cbphone'),
                        false, // address
                        false, // company
                        false, // department
                        false, // time
                        false, // comment admin
                        'callback' // group type
                    );
            }

                Shop::Get()->getCallbackService()->addCallback(
                    $this->getControlValue('cbname'),
                    $this->getControlValue('cbphone'),
                    '',
                    $user
                );

        }

        // заполняем по умолчанию данными форму callback'a
        try {
            $u = $this->getUser();

            if (!$this->getValue('ok')) {
                $this->setControlValue('cbname', $u->getName());
                $this->setControlValue('cbphone', $u->getPhone());
            }
        } catch (Exception $e) {

        }

    }


}