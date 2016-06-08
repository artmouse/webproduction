<?php

/**
 **
 *  
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * 
 * @copyright WebProduction
 * @package Package
 */
class GalleryService extends ServiceUtils_AbstractService {

    /**
     * *
     * @return ShopGallery
     */
    public function getGalleryAll() {
        $x = new ShopGallery();
        $x->setOrder(array('sort', 'cdate'), 'ASC');
        return $x;
    }

    /**
     * *
     * @return ShopGallery
     */
    public function getGalleryActive() {
        $x = $this->getGalleryAll();
        $x->setHidden(0);
        return $x;
    }

    /**
     * *
     * @return ShopGallery
     */
    public function getGalleryByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopGallery');
        } catch (Exception $e) {
            throw new ServiceUtils_Exception('ShopGallery by id not found');
        }
        
    }

    /**
     * *
     * @return ShopGallery
     * @param string $url
     */
    public function getGalleryByURL($url) {
        if (!$url) {
            throw new ServiceUtils_Exception();
        }

        $x = new ShopGallery();
        $x->setUrl($url);
        if ($x->select()) {
            return $x;
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * *
     * @return ShopGallery
     * @param ShopGallery $current
     */
    public function getGalleryNext(ShopGallery $current) {
        $gallery = $this->getGalleryActive();
        $gallery->addWhere('id', $current->getId(), '>');
        $gallery->setAlbum($current->getAlbum());
        $gallery->setLimitCount(1);
        if ($x = $gallery->getNext()) {
            return $x;
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * *
     * @return ShopGallery
     * @param ShopGallery $current
     */
    public function getGalleryPrev(ShopGallery $current) {
        $gallery = $this->getGalleryActive();
        $gallery->setOrder('id', 'DESC');
        $gallery->addWhere('id', $current->getId(), '<');
        $gallery->setAlbum($current->getAlbum());
        $gallery->setLimitCount(1);
        if ($x = $gallery->getNext()) {
            return $x;
        }

        throw new ServiceUtils_Exception();
    }
    

    /**
     * *
     * @return GalleryService
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __construct() {

    }

    private function __clone() {

    }

    private static $_Instance = null;

}