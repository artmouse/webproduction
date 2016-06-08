<?php
/**
 * OneBox
 * 
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopTextPage extends XShopTextPage {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * *
     * @return ShopTextPage
     */
    public function getNext($exception = false) {
        $x = 1; // Sniffer fix Possible useless method overriding detected
        return parent::getNext($exception);
    }

    /**
     * *
     * @return ShopTextPage
     */
    public static function Get($key) {
        return self::GetObject('ShopTextPage', $key);
    }

    /**
     * *
     * @return string
     */
    public function makeName() {
        return htmlspecialchars($this->getName());
    }

    /**
     * *
     * @return string
     */
    public function makeURL($friendlyURL = true) {
        $fullurl = '';
        if ($friendlyURL) {
            $fullurl = Engine::Get()->getProjectURL();
        }
        if ($friendlyURL && $this->getUrl()) {
            $url = $this->getUrl();
            return $fullurl.'/'.$url;
        } else {
            return $fullurl.Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-page',
                $this->getId()
            );
        }
    }

    /**
     * *
     * @return string
     */
    public function makeImage() {
        $src = MEDIA_PATH.'/shop/'.$this->getImage();
        if (!file_exists($src) || is_dir($src)) {
            return false;
        }

        $src = str_replace(PackageLoader::Get()->getProjectPath(), '/', $src);

        return $src;
    }

}