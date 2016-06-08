<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopProductTag extends XShopProductTag {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopProductTag
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopProductTag
     */
    public static function Get($key) {
        return self::GetObject('ShopProductTag', $key);
    }

    public function makeName($uppercase = false) {
        $name = $this->getName();
        if ($uppercase) {
            $name = mb_strtoupper(mb_substr($name, 0, 1)).mb_substr($name, 1);
        }
        return htmlspecialchars($name);
    }

    public function makeURL($friendlyURL = true) {
        if (!$this->getUrl()) {
            //$this->setUrl(Shop::Get()->getShopService()->buildURL($this->getName()).'-t'.$this->getId());
            $this->setUrl(Shop::Get()->getShopService()->buildURL($this->getName()));
            $this->update();
        }

        $fullurl = '';
        if ($friendlyURL) {
            if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                $h = 'https://';
            } else {
                $h = 'http://';
            }
            if (Engine::Get()->getProjectHost()) {
                $fullurl = $h.Engine::Get()->getProjectHost();
            }
        }
        if ($friendlyURL) {
            $url = '/'.$this->getUrl().'/';
            return $fullurl.$url;
        } else {
            return $fullurl.Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-tag',
            $this->getId()
            );
        }
    }

}