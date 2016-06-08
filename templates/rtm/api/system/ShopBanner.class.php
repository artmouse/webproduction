<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopBanner extends XShopBanner {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopBanner
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopBanner
     */
    public static function Get($key) {return self::GetObject('ShopBanner', $key);}

    /**
     * @return array
     */
    public function makeInfoArray($imageWidth=false, $imageHeight=false) {
        $a = array();
        $a['id'] = $this->getId();
        $a['name'] = $this->getName();
        $a['place'] = $this->getPlace();
        $a['comment'] = $this->getComment();
        $a['image'] = $this->makeImageThumb(700);
        $a['comment'] = $this->getComment();

        $url = $this->getUrl();
        $host = Shop_URLParser::Get()->getHost();
        if (preg_match('#^https?://'.preg_quote($host, '#').'/#', $url)) {
            // internal link
            $a['url'] = $url;
            $a['external'] = false;
        } else {
            // external link
            if (strpos($url, '?') === false) {
                $url .= '?utm_source='.urlencode($host).'&utm_medium=banner_'.$a['place'].'&utm_campaign='.urlencode($a['name']);
            }

            $a['url'] = Engine::Get()->GetLinkMaker()->makeURLByContentIDParams(
            'shop-click',
            array(
            'url' => urlencode($url),
            'id' => $this->getId()
            )
            );
            $a['external'] = true;
        }

        return $a;
    }

    /**
     * Получить оригинальное изображение
     *
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

    /**
     * Получить уменьшенное изображение
     *
     * @param int $width
     * @param int $height
     * @param string $method
     * @return string
     */
    public function makeImageThumb($width = 500, $height = false, $method = 'prop') {
        $src = MEDIA_PATH.'/shop/'.$this->getImage();
        if (!file_exists($src) || is_dir($src)) {
            return false;
        }

        // получаем формат
        $format = Shop::Get()->getSettingsService()->getSettingValue('image-format');
        $format = strtolower($format);
        if ($format != 'png' && $format != 'jpg') {
            $format = 'png';
        }

        // ширина меньше 100px смысла не имеет
        if ($width <= 100) {
            $width = 100;
        }

        // приводим размер изображений к кратности 100px (в большую сторону)
        // $width = round(ceil($width / 100) * 100);

        return ImageProcessor_Thumber::makeThumbUniversal($src, $width, $height, $method, PROJECT_PATH, $format);
    }

}