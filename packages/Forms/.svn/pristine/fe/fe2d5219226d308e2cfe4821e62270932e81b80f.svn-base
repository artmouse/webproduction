<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ContentFieldDatetime extends Forms_ContentField {

    public function __construct($key, $viewFormat = false) {
        PackageLoader::Get()->import('DateTime');
        PackageLoader::Get()->import('Checker');

        parent::__construct($key);
        $this->setViewFormat($viewFormat);

        $this->getContentControl()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'_Control.html');

        $this->setValueDefault(date('Y-m-d H:i:s'));
    }

    /**
	 * Отрисовать поле для просмотра (в табличном выводе, например).
	 *
	 * @param int $rowIndex
	 * @param array $cellsArray
	 * @return string
	 */
    public function renderView($rowIndex, $cellsArray) {
        $value = @$cellsArray[$this->getKey()];
        if (!Checker::CheckDate($value)) {
            return '';
        }

        if ($this->_viewFormat) {
            return DateTime_Object::FromString($value)->setFormat($this->_viewFormat)->__toString();
        }

        return $value;
    }

    /**
     * Отрисовать контрол поля
     * для форм редактирования / добавления
     *
     * @param mixed $value
     * @return string
     */
    public function renderControl($value = false) {
        $assigns = array();

        if (!$value) {
            $value = $this->getValueDefault();
        }

        // $assigns['name'] = $this->getName();
        $assigns['key'] = $this->getKey();
        $assigns['value'] = htmlspecialchars($value);
        $assigns['disabled'] = $this->getDisabled();

        // путь к директории /media/ внутри Forms
        $assigns['mediapath'] = str_replace(PackageLoader::Get()->getProjectPath(), '/', dirname(__FILE__).'/media/');

        return $this->getContentControl()->render($assigns);
    }

    public function getValue() {
        $x = parent::getValue();

        if ($x) {
            $x = DateTime_Corrector::CorrectDateTime($x);
        }

        return $x;
    }

    /**
     * Задать формат отображения даты в ячейке
     *
     * @param string $viewFormat
     */
    public function setViewFormat($viewFormat) {
        $this->_viewFormat = $viewFormat;
    }

    /**
     * Получить формат отображения даты в ячейке
     *
     * @return string
     */
    public function getViewFormat() {
        return $this->_viewFormat;
    }

    public function setValueDefault($value) {
        $this->_valueDefault = $value;
    }

    public function getValueDefault() {
        return $this->_valueDefault;
    }

    private $_viewFormat = false;

    private $_valueDefault;

}