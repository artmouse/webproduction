<?php
/**
 * Проверка размера(ширина и высота) картинки
 *
 * @author Oleksii Golub <avator@webproduction.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ValidatorImageWidthHeight extends Forms_AValidator {

    public function __construct($width, $height) {
        $this->_width = $width;
        $this->_height = $height;
    }

    public function validate($data) {
    	$data = getimagesize(MEDIA_PATH.'/shop/'.$data);
        if (!$this->_height || !$this->_width)
            return false;
        if ($data[1] > $this->_height || $data[0] > $this->_width)
            return false;
        return true;
    }

    private $_width = 0;
    private $_height = 0;

}