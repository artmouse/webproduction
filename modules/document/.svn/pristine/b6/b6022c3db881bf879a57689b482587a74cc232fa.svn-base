<?php
/**
 * OneBox
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopDocument extends XShopDocument {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopDocument
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopDocument
     */
    public static function Get($key) {
        return self::GetObject('ShopDocument', $key);
    }

    /**
     * @return User
     */
    public function getUser() {
        return Shop::Get()->getUserService()->getUserByID($this->getUserid());
    }

    /**
     * @return ShopDocumentTemplate
     */
    public function getTemplate() {
        return DocumentService::Get()->getDocumentTemplateByID($this->getTemplateid());
    }

    /**
     * Построить имя документа
     *
     * @return string
     */
    public function makeName() {
        $x = $this->getName();
        if ($x) {
            return htmlspecialchars($x);
        }
        return htmlspecialchars($this->getTemplate()->getName());
    }

    public function makeURLPrint() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'shop-admin-document-print',
        $this->getId()
        );
    }

    public function makeURLPDF() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'shop-admin-document-pdf',
        $this->getId()
        );
    }

    /**
     * @deprecated
     * @see makeURLEdit()
     *
     * @return unknown
     */
    public function makeURLUpload() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'shop-admin-document-control',
        $this->getId()
        );
    }

    public function makeURLEdit() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'shop-admin-document-control',
        $this->getId()
        );
    }

    public function makeURLFileOriginal() {
        if ($this->getFileoriginal()) {
            return '/media/document/'.$this->getFileoriginal();
        } else {
            return false;
        }
    }

    public function makeURLFile() {
        if ($this->getFile()) {
            return '/media/document/'.$this->getFile();
        } else {
            return false;
        }
    }

    public function getNumber() {
        $x = parent::getNumber();
        if ($x) {
            return $x;
        }
        return $this->getId();
    }

    /**
     * Получить штрих-код
     *
     * @return string
     */
    public function makeBarcode() {
        $file = MEDIA_PATH.'/document/barcode'.$this->getId().'.png';
        Shop::Get()->getShopService()->createBarcodeImage($file, $this->getId());
        return MEDIA_DIR.'/document/barcode'.$this->getId().'.png?'.time();
    }

    /**
     * @param int $w
     * @param int $h
     * @param string $type
     * @return string
     */
    public function makeScanThumb($w = 100, $h = false, $type = 'prop') {
        $file = $this->getFile();

        if ($file && file_exists(PROJECT_PATH.MEDIA_DIR.'/document/'.$file)) {
            $file = MEDIA_DIR.'/document/'.$file;

            try {
                PackageLoader::Get()->import('ImageProcessor');

                if ($type == 'prop') {
                    $p = ImageProcessor_Thumber::MakeThumbProportional(PROJECT_PATH.$file, $w, $h);
                } elseif ($type == 'crop') {
                    $p = ImageProcessor_Thumber::MakeThumbCrop(PROJECT_PATH.$file, $w, $h);
                }

                return str_replace(PROJECT_PATH, '', $p);
            } catch (Exception $e) {}
        }

        return false;
    }

}