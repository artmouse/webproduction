<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2016 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * ServiceUtils_AbstractService
 *
 * @author    Max
 * @copyright WebProduction
 * @package   ServiceUtils
 */
abstract class ServiceUtils_AbstractService {

    protected function _setServiceClassName($classname) {
        $this->_classname = $classname;
    }

    protected function _getServiceClassName() {
        return $this->_classname;
    }

    /**
     * Получить объект по ID
     *
     * @param int $objectID
     *
     * @return SQLObject
     *
     * @throws ServiceUtils_Exception
     */
    public function getObjectByID($objectID, $classname = false) {
        if ($objectID > 0) {
            if (!$classname) {
                $classname = $this->_getServiceClassName();
            }
            try {
                return SQLObject::GetObject($classname, $objectID);
            } catch (Exception $e) {

            }
        }
        throw new ServiceUtils_Exception("$classname-object by id not found");
    }

    /**
     * Получить объект по определенному полю
     *
     * @param int $objectID
     * @param bool $unique
     *
     * @return SQLObject
     *
     * @throws ServiceUtils_Exception
     */
    public function getObjectByField($fieldName, $fieldValue, $classname = false, $unique = true) {
        if (!$classname) {
            $classname = $this->_getServiceClassName();
        }
        if (!$fieldName) {
            throw new ServiceUtils_Exception('Empty fild name');
        }

        try {
            $x = new $classname();
            $x->setField($fieldName, $fieldValue);
            if ($unique) {
                if ($x->getCount() == 1) {
                    return $x->getNext();
                }
            } else {
                if ($x->select()) {
                    return $x;
                }
            }
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception("$classname-object by $fieldName not found");
    }

    /**
     * Получить все объекты
     *
     * @return object
     */
    public function getObjectsAll($classname = false) {
        if (!$classname) {
            $classname = $this->_getServiceClassName();
        }
        $x = new $classname();
        $x->setOrder("id", "ASC");
        return $x;
    }

    private $_classname;

}