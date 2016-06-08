<?php
class products_list_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_ProductsList());

            $autoplay = $form->getField('autoplay');
            $autoplay->setName(
                Shop::Get()->getTranslateService()->getTranslateSecure(
                    'translate_avtomaticheskaya_prokrutka_tolko_dlya_karuseli'
                )
            );

            $listID = $this->getArgumentSecure('key');
            if ($listID)
                $form->denyInsert();

            $this->setValue('form', $form->render($listID));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }

    }

}