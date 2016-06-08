<?php
/**
 * Событие, которое используется только для getField, setField (подмены полей)
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package SQLObject
 */
class SQLObject_EventField extends SQLObject_Event {

    /**
     * Задать название поля
     *
     * @param string $fieldName
     */
    public function setFieldName($fieldName) {
        $this->_fieldName = $fieldName;
    }

    /**
     * Получить название поля
     *
     * @return string
     */
    public function getFieldName() {
        return $this->_fieldName;
    }

    /**
     * Задать значение поля
     *
     * @param string $fieldName
     */
    public function setFieldValue($fieldValue) {
        $this->_fieldValue = $fieldValue;
    }

    /**
     * Получить значение поля
     *
     * @return string
     */
    public function getFieldValue() {
        return $this->_fieldValue;
    }

    private $_fieldName;

    private $_fieldValue;

}