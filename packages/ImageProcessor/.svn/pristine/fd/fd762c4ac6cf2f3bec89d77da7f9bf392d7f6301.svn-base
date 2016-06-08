<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2013 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Action: proroptional image resize.
 * Пропорционально уменьшить размер изображения до заданного
 *
 * @package ImageProcessor
 * @copyright WebProduction
 * @author Max
 */
class ImageProcessor_ActionResizeProportional extends ImageProcessor_Action {

    public function process() {
        $im = $this->getImageResource();

        // получаем размеры оригинального изображения
        $w = imagesx($im);
        $h = imagesy($im);

        // размеры, к которым нужно ужать
        $width = $this->_width;
        $height = $this->_height;

        if ($height) {
            $mul_h = $height/$h;
        }else $mul_h = 2147483647;

        if ($width) {
            $mul_w = $width/$w;
        } else $mul_w = 2147483647;

        $mul = min($mul_h, $mul_w);

        $width = $w*$mul;
        $height = $h*$mul;

        $image = imagecreatetruecolor($width, $height);
        imagefill($image, 0, 0, 0xffffff);

        imagecopyresampled($image, $im, 0, 0, 0, 0, $width, $height, imagesx($im), imagesy($im));

        return $image;
    }

    /**
     * Proroptional image resize.
     *
     * @param int $width
     * @param int $height
     */
    public function __construct($width = false, $height = false) {
        $this->_width = $width;
        $this->_height = $height;
    }

    private $_width;

    private $_height;

}