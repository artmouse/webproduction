<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 13.03.14
 * Time: 13:39
 */

class Datasource_TypeSex extends  Forms_ADataSourceEnum{

 public function __construct($optionsArray = false) {
        parent::__construct($optionsArray);

        $this->addOption('man', Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_man'));
        $this->addOption('woman', Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_woman'));
        $this->addOption('company', Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_company'));
        $this->addOption('undefined', Shop::Get()->getTranslateService()->getTranslateSecure('translate_undefined'));
    }

}