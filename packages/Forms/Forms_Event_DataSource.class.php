<?php
/**
 * Событие для Forms_ADataSource и наследников
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Forms
 */
class Forms_Event_DataSource extends Events_Event {

    /**
     * Задаь объект
     *
     * @param Forms_ADataSource $object
     */
    public function setObject(Forms_ADataSource $object) {
        $this->_object = $object;
    }

    /**
     * Получить объект
     *
     * @return Forms_ADataSource
     */
    public function getObject() {
        return $this->_object;
    }

    private $_object;

}