<?php

class ShopTextPage extends XShopTextPage {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }


    public function getNext($exception = false) {
        $obj = new XShopTextPage();
        return $obj->getNext($exception);
    }


    public static function Get($key) {
        return self::GetObject('ShopTextPage', $key);
    }


    public function makeName() {
        return htmlspecialchars($this->getName());
    }


    public function makeURL($friendlyURL = true) {
        $fullurl = '';
        if ($friendlyURL) {
            $fullurl = Engine::Get()->getProjectURL();
        }
        if ($friendlyURL && $this->getUrl()) {
            $url = $this->getUrl();
            $this->_makeRedirect();
            return $fullurl.'/'.$url.'/';
        } else {
            $this->_makeRedirect();
            return $fullurl.Engine::GetLinkMaker()->makeURLByContentIDParam('shop-page', $this->getId());
        }
    }


    public function makeImage() {
        $src = MEDIA_PATH.'/shop/'.$this->getImage();
        if (!file_exists($src) || is_dir($src)) {
            return false;
        }

        $src = str_replace(PackageLoader::Get()->getProjectPath(), '/', $src);

        return $src;
    }


    private function _makeRedirect() {
        $full_url = Engine::Get()->getProjectURL();
        $redirect = new XShopRedirect();
        $redirect->setUrlfrom('/'.$this->getUrl());
        if (!$redirect->select()) {
            $redirect->setUrlto($full_url.'/'.$this->getUrl().'/');
            $redirect->setCode(301);
            $redirect->insert();
        }
    }

}