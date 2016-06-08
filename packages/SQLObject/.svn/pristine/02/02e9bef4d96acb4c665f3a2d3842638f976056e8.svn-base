<?php
/**
 * WebProduction Packages. SQLObject.
 * Copyright (C) 2007-2016 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * SQLObject - класс который позволяет отражать строки таблицы в объекты.
 * Simple ORM.
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   SQLObject
 */
class SQLObject {

    /**
     * Получить соединение с базой данных
     *
     * @return ConnectionManager_IConnection
     */
    public function getConnectionDatabase() {
        if (!$this->_connectionDatabase) {
            throw new SQLObject_Exception('No connection');
        }
        return $this->_connectionDatabase;
    }

    /**
     * Задать соединение с базой данных
     *
     * @param ConnectionManager_IConnection $connection
     */
    public function setConnectionDatabase(ConnectionManager_IConnection $connection) {
        $this->_connectionDatabase = $connection;
    }

    /**
     * Создать объект на основе массива
     *
     * @param array $array
     *
     * @return SQLObject
     */
    public static function FromArray($array, $classname) {
        $obj = self::_NewClassname($classname);
        $obj->setValues($array);

        $key = $obj->getPrimaryKey();
        if (isset($array[$key])) {
            $obj->_id = $array[$key];
        }

        return $obj;
    }

    /**
     * Создать объект по ключу в таблице (в большинстве случаев - по ID)
     *
     * @param int $id
     *
     * @todo избавиться от ID-параметра
     */
    public function __construct($id = 0) {
        // по умолчанию указываем соединение из общего конфига
        $this->setConnectionDatabase(
            SQLObject_Config::Get()->getConnectionDatabase($this->getClassname())
        );

        // система безопастности не позволит создать объект
        // с использованием SQL-injection'a
        if (!$id || !is_numeric($id) || substr_count($id, '.')) {
            if ($id) {
                throw new SQLObject_Exception('Invalid primary key: '.$id);
            }
            return false;
        } else {
            $this->_id = $id;
            $this->select();
        }
    }

    /**
     * Получить список полей для объекта.
     * Вернется линейный массив.
     *
     * @return array
     */
    public function getFields() {
        return self::$_FieldArray[$this->getTablename()];
    }

    public static function SetFieldArray($tablename, $fieldArray) {
        self::$_FieldArray[$tablename] = $fieldArray;
    }

    /**
     * Задать массив значений всем полям сразу
     *
     * @param array $a
     */
    public function setValues($a) {
        if (!$this->_values) {
            $this->_values = $a;
        } else {
            // мерж выполняется крайне редко
            $this->_values = array_merge($this->_values, $a);
        }
    }

    /**
     * Получить список значений полей всего объекта.
     * Вернется ассоциативный массив key-value (2D-array)
     *
     * @return array
     */
    public function getValues() {
        return $this->_values;
    }

    /**
     * Получить массив полей к обновлению
     *
     * @return array
     */
    public function getValueUpdateArray() {
        return $this->_valueUpdateArray;
    }

    /**
     * Вставить объект в таблицу.
     * Вернет id вставленной строки.
     * Внутри по сути обычный INSERT
     *
     * @return int
     */
    public function insert() {
        // event
        $this->_notifyEvent('SQLObject.insert.before');

        // event
        $this->_notifyEvent($this->getClassname().'.insert.before');

        $s = '';
        foreach ($this->getFields() as $f) {
            $x = $this->getField($f);
            if ($x instanceof SQLObject_FieldValue) {
                $x = $x->__toString();
            } else {
                $x = $this->getConnectionDatabase()->escapeString($x);
                $x = "'".$x."'";
            }
            $s .= "`{$f}`={$x}, ";
        }
        if (!$s) {
            return false;
        }

        $s = trim($s, ', ');
        $query = "INSERT INTO `$this->_table` SET $s";

        $this->_query($query);
        $this->_id = $this->getConnectionDatabase()->getLastInsertID();
        $this->setField($this->getPrimaryKey(), $this->_id);

        // очищаем массив update-полей
        $this->_fieldsQueryArray = array();

        // event
        $this->_notifyEvent('SQLObject.insert.after');

        // event
        $this->_notifyEvent($this->getClassname().'.insert.after');

        return $this->_id;
    }

    /**
     * Обновить объект или объекты на физическом уровне.
     * При массовом обновлении надо передать $massUpdate=true. Защита от лоха.
     *
     * @param bool $massUpdate
     *
     * @return bool
     */
    public function update($massUpdate = false) {
        // event
        $this->_notifyEvent('SQLObject.update.before');

        // event
        $this->_notifyEvent($this->getClassname().'.update.before');

        if ($this->_id && $massUpdate) {
            throw new SQLObject_Exception('Cannot update objects: id already defined.');
        }

        if (!$this->_id && !$massUpdate) {
            throw new SQLObject_Exception('Cannot update object: primary key not defined.');
        }

        // если нет данных к обновлению
        if (!$this->getValueUpdateArray()) {
            return false;
        }

        $s = '';

        // update только определенных к обновлению полей!
        foreach ($this->_valueUpdateArray as $field => $value) {
            // пропускаем первичный ключ (id)
            if ($field == $this->getPrimaryKey()) {
                continue;
            }

            if ($value instanceof SQLObject_FieldValue) {
                $value = $value->__toString();
            } else {
                $value = $this->getConnectionDatabase()->escapeString($value);
                $value = "'".$value."'";
            }
            $s .= "`{$field}`={$value}, ";
        }

        if (!$s) {
            // @todo exception?
            return false;
        }

        $s = trim($s, ', ');

        if ($this->_id) {
            // единичное обновление
            $query = "UPDATE `$this->_table` SET $s WHERE `".$this->getPrimaryKey()."`='$this->_id' LIMIT 1";
            $this->_query($query);
        } elseif ($massUpdate) {
            // массовое обновление
            $query = "UPDATE `$this->_table` SET $s WHERE ".$this->makeWhereString();
            $this->_query($query);

            // убираемся из pool'a
            SQLObject_Pool::GetPool()->clear($this->getClassname());
        }

        // event
        $this->_notifyEvent('SQLObject.update.after');

        // event
        $this->_notifyEvent($this->getClassname().'.update.after');

        // запрос успешно выполнен
        return true;
    }

    /**
     * Установить разделитель в запросе WHERE
     * По умолчанию AND
     *
     * @param string $default
     */
    public function setWhereSeparator($default = 'AND') {
        $this->_whereseparator = $default;
    }

    /**
     * Выбрать объект по идентификатору или заданным полям
     * Объект выбирается только один и считается конечным
     * Вернет true если объект был выбран
     *
     * @todo возможно стоит добавить кеширование
     * @todo и занесение в пул?
     * @todo переделать вызов на getNext() like SQLObject3? + isSelected()
     *
     * @return bool
     */
    public function select() {
        $key = $this->getPrimaryKey();

        $more = '';
        if ($this->_id) {
            $more .= "`".$key."`='$this->_id'";
        } else {
            $more .= '1=1';
        }
        foreach ($this->_values as $f => $v) {
            if ($v instanceof SQLObject_FieldValue) {
                $v = $v->__toString();
            } else {
                $v = $this->getConnectionDatabase()->escapeString($v);
                $v = "'".$v."'";
            }
            $more .= " {$this->_whereseparator} `{$f}`={$v}";
        }

        $query = "SELECT * FROM `$this->_table` WHERE $more LIMIT 1";
        $q = $this->_query($query);

        if ($x = $this->getConnectionDatabase()->fetch($q)) {
            //$this->setValues($x);
            $this->_values = $x;
            /*foreach ($x as $f => $v) {
                $this->_values[$f] = $v;
            }*/
            $this->_id = $x[$key];
            $this->_clearQueryInternal();
        }

        if ($this->getField($key)) {
            return true;
        }

        return false;
    }

    /**
     * Удалить объект из таблицы
     * Возвращает true если удалось удалитью
     *
     * При массовом удалении надо передать $massDelete=true. Защита от лоха.
     *
     * @param bool $massDelete
     *
     * @return bool
     */
    public function delete($massDelete = false) {
        // event
        $this->_notifyEvent('SQLObject.delete.before');

        // event
        $this->_notifyEvent($this->getClassname().'.delete.before');

        if ($this->_id && $massDelete) {
            throw new SQLObject_Exception('Cannot delete objects: id already defined.');
        }

        if (!$this->_id && !$massDelete) {
            throw new SQLObject_Exception('Cannot delete object: primary key not defined.');
        }

        if ($this->_id) {
            // единичное удаление
            $this->_query("DELETE FROM `$this->_table` WHERE `".$this->getPrimaryKey()."`='$this->_id' LIMIT 1");

            // убираем объект из пула
            SQLObject_Pool::GetPool()->delete($this->getClassname(), $this->_id);
        } elseif ($massDelete) {
            // массовое удаление
            $this->_query("DELETE FROM `$this->_table` WHERE ".$this->makeWhereString());

            // очищаем весь пул
            SQLObject_Pool::GetPool()->clear($this->getClassname());
        }

        // очищаем массив update-полей
        $this->_fieldsQueryArray = array();

        // event
        $this->_notifyEvent('SQLObject.delete.after');

        // event
        $this->_notifyEvent($this->getClassname().'.delete.after');

        return true;
    }

    /**
     * Получить значение указанного поля.
     * Внимание! Метод можно изменить событием Class.getField.after с типом события SQLObject_EventField.
     *
     * @param string $field
     * @param bool $events
     *
     * @return mixed
     */
    public function getField($field, $events = true) {
        if (isset($this->_values[$field])) {
            $value = $this->_values[$field];
        } else {
            $value = false;
        }

        // event
        if ($events) {
            $eventName = $this->getClassname().'.getField.after';
            // быстрая проверка на "есть или нет" события
            if (Events::Get()->hasEvent($eventName)) {
                $event = Events::Get()->generateEvent($eventName);
                $event->setObject($this);
                $event->setFieldName($field);
                $event->setFieldValue($value);
                $event->notify();

                // получаем подмененное значение
                $value = $event->getFieldValue();
            }
        }

        return $value;
    }

    /**
     * Установить значение указанного поля
     * Внимание! Метод можно изменить событием Class.setField.Befire с типом события SQLObject_EventField.
     *
     * @param string $field
     * @param mixed $value
     *
     * @todo это update, а не фильтр
     * @todo что делать если передаваемого поля нет в fields?
     */
    public function setField($field, $value, $update = false) {
        // event
        $eventName = $this->getClassname().'.setField.before';
        // быстро проверяем есть вообще обработчики или нет
        if (Events::Get()->hasEvent($eventName)) {
            $event = Events::Get()->generateEvent($eventName);
            $event->setObject($this);
            $event->setFieldName($field);
            $event->setFieldValue($value);
            $event->notify();

            // получаем подмененные значение и названия поля
            $field = $event->getFieldName();
            $value = $event->getFieldValue();
        }

        if (is_object($value) && $value === $this) {
            throw new SQLObject_Exception('Cannot set an RECURSIVE object into setField()');
        }

        if (is_object($value) && !method_exists($value, '__toString')) {
            throw new SQLObject_Exception('Cannot set an object into setField() without __toString() declaration');
        }

        if (isset($this->_values[$field])) {
            $oldValue = $this->_values[$field];
        } else {
            $oldValue = false;
        }

        if (!$update) {
            $this->_clearQueryInternal();
            $this->_values[$field] = $value;
        }

        // если объект выбран - то дополнительно записываем данные
        // в update-field
        if ($this->_id || $update) {
            $this->_valueUpdateArray[$field] = $value;

            // если надо сохранять данные
            if (!self::$_noValuesSave) {
                // если сейчас открыта транзакция - то записываем в revert pool
                // текущее состояние объекта (все поля)
                $transactionLevel = SQLObject_Config::Get()->getConnectionDatabase()->getTransactionLevel();
                if ($transactionLevel) {
                    SQLObject_RevertPool::Get()->add($this, $transactionLevel, $field, $oldValue);
                }
            }
        }
    }

    public function revertField($field, $value) {
        $this->_values[$field] = $value;
    }

    /**
     * Фильтровать объекты по указанному полю.
     * $operation по умолчанию равен =, но можно заменить на !=, <, >, >=, <=, LIKE и тд.
     *
     * @param string $fieldName
     * @param mixed $fieldValue
     * @param string $operation
     *
     * @todo что делать если передаваемого поля нет в fields?
     */
    public function filterField($fieldName, $fieldValue, $operation = false) {
        // если есть оператор - то используем addWhere()
        if ($operation && $operation != '=') {
            $this->addWhere($fieldName, $fieldValue, $operation);
            return;
        }

        if (!$fieldName) {
            throw new SQLObject_Exception('Empty fieldName');
        }

        if (is_object($fieldValue) && $fieldValue === $this) {
            throw new SQLObject_Exception('Cannot set an RECURSIVE object into filterField()');
        }

        if (is_object($fieldValue) && !method_exists($fieldValue, '__toString')) {
            throw new SQLObject_Exception('Cannot set an object into filterField() without __toString() declaration');
        }

        if (is_array($fieldValue)) {
            $this->addWhereArray($fieldValue, $fieldName);
            return;
        }

        $this->_clearQueryInternal();
        $this->_values[$fieldName] = $fieldValue;
    }

    /**
     * Убрать фильтровку с поля
     *
     * @param string $fieldName
     */
    public function unfilterField($fieldName) {
        if (!$fieldName) {
            throw new SQLObject_Exception('Empty fieldName');
        }

        unset($this->_values[$fieldName]);
    }

    public function unsetField($f) {
        unset($this->_values[$f]);
        unset($this->_valueUpdateArray[$f]);
    }

    /**
     * Получить имя таблицы с которой работаем
     * Формально метод должен быть protected
     *
     * @return string
     */
    public function getTablename() {
        return $this->_table;
    }

    /**
     * Установить имя таблицы, с которой работать
     *
     * @param string $table
     */
    public function setTablename($table) {
        $this->_clearQueryInternal();
        $this->_table = $table;
    }

    /**
     * Задать набор условий WHERE
     *
     * @param array $array
     */
    public function setWhere($array) {
        $this->_clearQueryInternal();
        $this->_q_where = $array;
    }

    /**
     * Добавить условие в WHERE
     *
     * @param string $field
     * @param mixed $value
     * @param string $operator
     */
    public function addWhere($field, $value, $operator = '=') {
        if (is_object($value) && !method_exists($value, '__toString')) {
            throw new SQLObject_Exception('Cannot set an object into addWhere()');
        }

        if (is_array($value)) {
            $this->addWhereArray($value, $field, $operator);
            return;
        }

        $this->_clearQueryInternal();
        $x['f'] = $field;
        $x['v'] = $value;
        $x['o'] = $operator;
        $this->_q_where[] = $x;
    }

    /**
     * Добавить в условие WHERE фрагмент запроса
     *
     * @param string $query
     */
    public function addWhereQuery($query) {
        $this->_q_where[] = $query;
    }

    /**
     * Добавить в WHERE массив фрагментов
     *
     * @param array $valueArray
     * @param string $field
     * @param string $operator
     * @param string $separator
     */
    public function addWhereArray($valueArray, $field = 'id', $operator = '=', $separator = 'OR') {
        if (!$valueArray) {
            return false;
            // @todo
            throw new SQLObject_Exception('Empty values not accepted');
        }

        if (!preg_match("/([\(\)\.,`]+)/uis", $field)) {
            $field = "`{$this->getTablename()}`.`{$field}`";
        }

        if ($operator == '=' && $separator == 'OR') {
            if (count($valueArray) == 1) {
                foreach ($valueArray as $value) {
                    $value = $this->getConnectionDatabase()->escapeString($value);
                    break;
                }
                // если значение только одно - то лучше IN заменить на =
                $query = '('.$field.'=\''.$value.'\')';
            } else {
                // если значений несколько - то используем IN
                $tmp = array();
                foreach ($valueArray as $value) {
                    $value = $this->getConnectionDatabase()->escapeString($value);
                    $tmp[] = "'{$value}'";
                }
                $query = '('.$field.' IN ('.implode(',', $tmp).'))';
            }
        } else {
            // если операторы сравнения не стандартные
            $query = '';
            foreach ($valueArray as $value) {
                $value = $this->getConnectionDatabase()->escapeString($value);
                $query .= $field.' '.$operator." '".$value."' ".$separator." ";
            }
            $query = '(' . substr($query, 0, -1*(strlen($separator)+2)) . ')';
        }
        $this->_q_where[] = $query;
    }

    /**
     * Очистить все условия WHERE
     */
    public function clearWhere() {
        $this->_q_where = array();
    }

    /**
     * Получить массив условий WHERE
     *
     * @return array
     */
    public function getWhere() {
        return $this->_q_where;
    }

    /**
     * Получить массив WHERE
     *
     * @return array
     */
    public function makeWhereArray() {
        $whereArray = array();

        $w = $this->getWhere();
        if ($w) {
            foreach ($w as $wx) {
                if (!is_array($wx)) {
                    $whereArray[] = $wx;
                } else {
                    $wx['v'] = $this->getConnectionDatabase()->escapeString($wx['v']);

                    if (!preg_match("/([\(\)\.,`]+)/uis", $wx['f'])) {
                        $wx['f'] = "`{$this->getTablename()}`.`$wx[f]`";
                    }

                    $whereArray[] = "{$wx['f']} {$wx['o']} '{$wx['v']}'";
                }
            }
        }

        // дописываем в where условия от полей
        if ($this->_values) {
            foreach ($this->_values as $vxname => $vxvalue) {
                if ($vxvalue instanceof SQLObject_FieldValue) {
                    $vxvalue = $vxvalue->__toString();
                } else {
                    $vxvalue = $this->getConnectionDatabase()->escapeString($vxvalue);
                    $vxvalue = "'".$vxvalue."'";
                }

                // @todo: подобные конструкции лучше переделывать на preg_match()
                if (!substr_count($vxname, '.')
                && !substr_count($vxname, '`')
                && !substr_count($vxname, ' ')) {
                    $vxname = "`{$this->getTablename()}`.`{$vxname}`";
                }

                $whereArray[] = $vxname.'='.$vxvalue;
            }
        }

        // если where нет - 1=1
        if (!$whereArray) {
            $whereArray[] = '1=1';
        }

        return $whereArray;
    }

    /**
     * Получить строку WHERE
     *
     * @return string
     */
    public function makeWhereString() {
        return implode(' '.$this->_whereseparator.' ', $this->makeWhereArray());
    }

    /**
     * Установить лимит выборки
     *
     * @param int $from
     * @param int $count
     */
    public function setLimit($from, $count) {
        $this->setLimitFrom($from);
        $this->setLimitCount($count);
    }

    /**
     * Установить лимит выборки ОТ
     *
     * @param int $from
     */
    public function setLimitFrom($from) {
        $this->_clearQueryInternal();
        $this->_limitfrom = $from;
    }

    /**
     * Получить лимит выборки ОТ
     *
     * @return int
     */
    public function getLimitFrom() {
        return $this->_limitfrom;
    }

    /**
     * Установить лимит выборки КОЛИЧЕСТВО от
     *
     * @param int $count
     */
    public function setLimitCount($count) {
        $this->_clearQueryInternal();
        $this->_limitcount = $count;
    }

    /**
     * Получить лимит выборки КОЛИЧЕСТВО от
     *
     * @return int
     */
    public function getLimitCount() {
        return $this->_limitcount;
    }

    /**
     * Установить сортировку при выборке ORDER BY
     *
     * @param string $by
     * @param string $type
     */
    public function setOrder($by, $type = 'ASC') {
        $this->setOrderBy($by);
        $this->setOrderType($type);
    }

    /**
     * Установить случайную сортировку.
     * Не рекомендуется использовать для больших выборок (более 1000 записей в таблице).
     */
    public function setOrderByRAND() {
        $this->setOrder('RAND()');
    }

    /**
     * Установить колонку по которой сортировать
     *
     * @param string $by
     */
    public function setOrderBy($by) {
        $this->_clearQueryInternal();
        $this->_orderby = $by;
    }

    /**
     * Получить колонку по которой сортировать
     *
     * @return string
     */
    public function getOrderBy() {
        return $this->_orderby;
    }

    /**
     * Установить направление сортировки ASC или DESC
     *
     * @param string $type
     */
    public function setOrderType($type = 'DESC') {
        $this->_clearQueryInternal();
        $this->_ordertype = $type;
    }

    /**
     * Получить направление сортировки ASC или DESC
     *
     * @return string
     */
    public function getOrderType() {
        return $this->_ordertype;
    }

    /**
     * Очистить внутренний хеш-запрос.
     * Метод используют методы getNext
     *
     * @see getNext()
     */
    private function _clearQueryInternal() {
        $this->_q = false;
    }

    /**
     * Получить следующий объект из результата запроса
     *
     * @param bool $exception
     *
     * @return SQLObject
     */
    public function getNext($exception = false) {
        if (!$this->_q) {
            $query = $this->_makeQuery();

            // выполнение запроса
            $this->_q = $this->_query($query);
        }

        // фетчинг
        $x = $this->getConnectionDatabase()->fetch($this->_q);
        if ($x) {
            // получаем параметры объекта
            $classname = $this->getClassname();
            $key = $this->getPrimaryKey();

            // проверяем, есть ли объект в пуле
            $obj = SQLObject_Pool::GetPool()->get($classname, $key);
            if ($obj) {
                return $obj;
            }

            // иначе объекта нет в пуле
            if (count($x) == 1) {
                // есть только основной ключ - значит придется создавать объект по ключу
                // (в эту секцию заходим крайне редко)
                $obj = self::_NewClassname($classname);
                $obj->_id = $x[$this->getPrimaryKey()];
                $obj->select();
            } else {
                // объект можно создать на основе данных
                $obj = self::FromArray($x, $classname);
            }

            // добавляем в пул
            SQLObject_Pool::GetPool()->add($obj);

            return $obj;
        } else {
            // если дошли до конца - то начинаем все с начала
            $this->_clearQueryInternal();

            if ($exception) {
                throw new SQLObject_Exception('End of objects list');
            } else {
                return false;
            }
        }
    }

    /**
     * Получить количество объктов в результирующем запросе
     * Внимание! Не используйте этот метод если уже начали фетчинг!
     *
     * @return int
     */
    public function getCount($fKey = false) {
        // строим запрос
        $query = $this->_makeQuery(array('COUNT(*) as sqlobjectCount'), '', '');

        if ($fKey) {
            $query = str_replace("WHERE", " USE INDEX (`{$fKey}`) WHERE ", $query);
        }

        $q = $this->_query($query);
        if (!$this->_groupByQuery) {
            $cnt = $this->getConnectionDatabase()->fetch($q);
            $cnt = @$cnt['sqlobjectCount'];
            if (!$cnt) $cnt = 0;
            return $cnt;
        } else {
            // если задан GROUP BY, то нужно возвращать количество выбранных объектов
            // issue #9121
            return $this->_sql_num_rows($q);
        }
        return false;
    }

    private function _sql_num_rows($q) {
        $connection = $this->getConnectionDatabase();

        $cnt = 0;
        while ($x = $connection->fetch($q)) {
            $cnt ++;
        }
        return $cnt;
    }

    /**
     * Построить SQL-запрос
     *
     * @param array $redeclareFields
     * @param string $redeclareOrder
     * @param string $redeclareLimit
     *
     * @return string
     */
    private function _makeQuery($redeclareFields = false, $redeclareOrder = false, $redeclareLimit = false) {
        // все таблицы, участвующие в SELECT'e
        $tablesArray = array("`{$this->_table}`");

        // все поля выборки
        $fieldsArray = array("`{$this->_table}`.*");
        foreach ($this->_fieldsQueryArray as $fieldQuery) {
            $fieldsArray[] = $fieldQuery;
        }

        // joinим таблицы
        foreach ($this->_joinTables as $jt) {
            $joinTable = $jt['table'];
            if (!substr_count($joinTable, '.') && !substr_count($joinTable, ' ')) {
                $joinTable = '`'.$joinTable.'`';
            }

            $joinTable = $jt['type'].' '.$joinTable;
            if ($jt['where']) {
                $joinTable .= ' ON '.$jt['where'];
            }
            $tablesArray[] = $joinTable;
        }

        if ($redeclareFields !== false) {
            $fieldsArray = $redeclareFields;
        }

        // дописываем GROUP BY
        $groupByString = '';
        if ($this->_groupByQuery) {
            $groupByString = 'GROUP BY '.$this->_groupByQuery;
        }

        // строим финальный запрос
        $query = "SELECT ".implode(',', $fieldsArray).
        " FROM ".implode(' ', $tablesArray).
        " WHERE ".$this->makeWhereString().
        ' '.$groupByString;

        // дописываем ORDERы
        if ($redeclareOrder === false) {
            $orderby = $this->getOrderBy();
            if ($orderby) {
                if (is_array($orderby)) {
                    $query .= " ORDER BY ".implode(', ', $orderby);
                } else {
                    if (!preg_match("/([\(\)\.,`]+)/uis", $orderby)) {
                        $orderby = '`'.$this->getTablename().'`.`'.$orderby.'`';
                    }
                    $ordertype = $this->getOrderType();
                    $query .= " ORDER BY $orderby $ordertype ";
                }
            }
        } elseif ($redeclareOrder) {
            $query .= " ORDER BY {$redeclareOrder}";
        }

        // дописываем LIMITы
        if ($redeclareLimit === false) {
            $limitfrom = $this->getLimitFrom();
            $limitcount = $this->getLimitCount();
            if ($limitfrom) {
                $query .= " LIMIT $limitfrom, $limitcount";
            } elseif ($limitcount) {
                $query .= " LIMIT $limitcount";
            }
        } elseif ($redeclareLimit) {
            $query .= " LIMIT {$redeclareLimit}";
        }

        return $query;
    }

    /**
     * Запустить событие.
     * Метод проверяет есть такое событие $eventName или нет и запускает его.
     * Метод сделан ради оптимизации кода и убирания копи-паста (см его вызовы).
     * Метод сделан protected специально, на случай если нужно будет в каком-то классе полностью
     * погасить возможность делать события (like final).
     *
     * @param string $eventName
     */
    protected function _notifyEvent($eventName) {
        // проверить есть событие или нет выгоднее,
        // чем тупо создавать его, если не получится делать exception,
        // а потом гасить его
        if (Events::Get()->hasEvent($eventName)) {
            $event = Events::Get()->generateEvent($eventName);
            $event->setObject($this);
            $event->notify();
        }
    }

    /**
     * Показать запрос, который будет выполняться при getNext()
     *
     * @see getNext()
     *
     * @return string
     */
    public function __toString() {
        return $this->_makeQuery();
    }

    /**
     * Узнать первичный ключ таблицы.
     * По умолчанию - id
     *
     * @return string
     */
    public function getPrimaryKey() {
        return self::$_PrimaryKeyArray[$this->getTablename()];
    }

    /**
     * Задать первичный ключ для таблицы
     *
     * @param string $key
     */
    public static function SetPrimaryKey($tablename, $key) {
        self::$_PrimaryKeyArray[$tablename] = $key;
    }

    /**
     * Установить имя класса, объекты которого будет выдавать getNext
     *
     * @param string $classname
     *
     * @see getNext()
     */
    public function setClassname($classname) {
        $this->_classname = $classname;
    }

    /**
     * Получить имя класса, объекты которого будет выдавать getNext
     *
     * @see getNext()
     *
     * @return string
     */
    public function getClassname() {
        if ($this->_classname) {
            return $this->_classname;
        }
        return __CLASS__;
    }

    private function _query($query) {
        if (PackageLoader::Get()->getMode('debug')) {
            print $query."\n";
            $a = debug_backtrace();
            foreach ($a as $x) {
                print $x['file'].":".$x['line']."\n";
            }
            print "\n";
        }
        return $this->getConnectionDatabase()->query($query);
    }

    /**
     * Получить объект по какому-то значению...
     *
     * @param string $classname
     * @param string $field
     * @param mixed $value
     *
     * @return SQLObject
     */
    public static function GetObject($classname, $key) {
        if (!class_exists($classname)) {
            throw new SQLObject_Exception('Empty classname');
        }

        if (!$key) {
            throw new SQLObject_Exception('Empty key');
        }

        // пытаемся достать объект из пула
        $object = SQLObject_Pool::GetPool()->get($classname, $key);
        if ($object) {
            return $object;
        }

        // создаем объект
        $object = self::_NewClassname($classname);
        $object->_id = $key;
        $object->select();

        // и добавляем его в пулл
        if ($object->getField($object->getPrimaryKey())) {
            SQLObject_Pool::GetPool()->add($object);
            return $object;
        }

        throw new SQLObject_Exception("Cannot create object of classname '{$classname}' by key '{$key}'");
    }

    /**
     * Превратить объект в массив
     *
     * @param array $method
     * @param array $order
     * @param bool $multiMode
     *
     * @return array
     *
     * @deprecated обычно приводит к плохим последствиям
     */
    public function toArray($methods = array(), $order = array(), $multiMode = false) {
        if ($this->getId() && !$multiMode) {
            $data = array();
            foreach ($this->getFields() as $field) {
                if (isset($methods[$field]) && method_exists($this, $methods[$field])) {
                    $data[$field] = $this->$methods[$field]();
                    unset($methods[$field]);
                } elseif (method_exists($this, "get{$field}")) {
                    $method = "get{$field}";
                    $data[$field] = $this->$method();
                } else {
                    $data[$field] = $this->getField($field);
                }
            }
            foreach ($methods as $k => $method) {
                if (method_exists($this, $method)) {
                    $data[$k] = $this->$method();
                }
            }
            return $data;
        } else {
            $data = array();
            if ($order) {
                $this->setOrder($order);
            }
            while ($x = $this->getNext()) {
                $data[] = $x->toArray($methods, false);
            }
            return $data;
        }
    }

    /**
     * (INNER) JOIN таблицу.
     * Дописать INNER JOIN к запросу.
     *
     * @param string $table
     * @param string $whereString
     */
    public function innerJoinTable($table, $whereString) {
        $this->_joinTables[$table] = array(
        'type' => 'JOIN',
        'table' => $table,
        'where' => $whereString,
        );
    }

    /**
     * LEFT JOIN таблицу.
     * Дописать LEFT JOIN к запросу.
     *
     * @param string $table
     * @param string $whereString
     */
    public function leftJoinTable($table, $whereString) {
        $this->_joinTables[$table] = array(
        'type' => 'LEFT JOIN',
        'table' => $table,
        'where' => $whereString,
        );
    }

    /**
     * RIGHT JOIN таблицу.
     * Дописать RIGHT JOIN к запросу.
     *
     * @param string $table
     * @param string $whereString
     */
    public function rightJoinTable($table, $whereString) {
        $this->_joinTables[$table] = array(
        'type' => 'RIGHT JOIN',
        'table' => $table,
        'where' => $whereString,
        );
    }

    /**
     * Дописать к выборке необходимый SQL
     *
     * @param string $query
     */
    public function addFieldQuery($query) {
        $query = trim($query);
        if (!$query) {
            throw new SQLObject_Exception('No addon field query');
        }

        $this->_fieldsQueryArray[] = $query;
    }

    /**
     * Задать строку GROUP BY
     *
     * @param string $query
     */
    public function setGroupByQuery($query) {
        $this->_groupByQuery = $query;
    }

    /**
     * Получить строку GROUP BY
     *
     * @return string
     */
    public function getGroupByQuery() {
        return $this->_groupByQuery;
    }

    /**
     * Очистить строку GROUP BY
     */
    public function unsetGroupByQuery() {
        $this->_groupByQuery = '';
    }

    /**
     * Открыть транзакцию (start transaction)
     * Параметр $force определяет принудительное открытие транзации.
     * Если $force == false, то транзакция будет открыта только в том случае,
     * если все предыдущие завершены.
     *
     * @param bool $force
     *
     * @todo rename to non-static
     */
    public static function TransactionStart($force = false, $noValuesSave = false) {
        self::$_noValuesSave = $noValuesSave;
        SQLObject_Config::Get()->getConnectionDatabase()->transactionStart($force);
    }

    /**
     * Закрыть транзакцию (commit)
     * Если $force = true - то принудительный commit без учета того,
     * сколько транзакций было открыто до этого.
     *
     * @param bool $force
     *
     * @todo rename to non-static
     */
    public static function TransactionCommit($force = false) {
        $transactionLevel = SQLObject_Config::Get()->getConnectionDatabase()->getTransactionLevel();

        SQLObject_Config::Get()->getConnectionDatabase()->transactionCommit($force);

        // очищаем pool по этому уровню транзакции
        if ($transactionLevel) {
            SQLObject_RevertPool::Get()->clear($transactionLevel);
        }

        self::$_noValuesSave = false;
    }

    /**
     * Отменить транзакцию (rollback).
     * $force - принудительный rollback.
     *
     * @param bool $force
     *
     * @todo rename to non-static
     */
    public static function TransactionRollback($force = false) {
        $transactionLevel = SQLObject_Config::Get()->getConnectionDatabase()->getTransactionLevel();

        SQLObject_Config::Get()->getConnectionDatabase()->transactionRollback($force);
        SQLObject_Pool::GetPool()->clearAll();

        // откатываем pool по этому уровню
        if ($transactionLevel) {
            SQLObject_RevertPool::Get()->revert($transactionLevel);
        }

        self::$_noValuesSave = false;
    }

    /**
     * Имеются ли какие-либо условия (where) у объекта?
     *
     * @return bool
     */
    public function hasConditions() {
        if ($this->getValues()) {
            return true;
        }
        if ($this->_q_where) {
            return true;
        }
        return false;
    }

    /**
     * Создать объект заданного класса.
     *
     * Метод-lifehack: в php clone делается быстрее new :)
     *
     * @param string $classname
     *
     * @return SQLObject
     */
    private static function _NewClassname($classname) {
        if (empty(self::$_NewCacheArray[$classname])) {
            self::$_NewCacheArray[$classname] = new $classname();
        }
        return clone self::$_NewCacheArray[$classname];
    }

    private $_classname;

    private $_table;

    private $_values = array();

    /**
     * Массив полей, подлежащих обновлению (SQL: UPDATE).
     * Устанавливается через setField() когда объект выбран.
     *
     * @var array
     */
    private $_valueUpdateArray = array();

    private $_id;

    private $_whereseparator = 'AND';

    private $_fieldsQueryArray = array();

    private $_groupByQuery = '';

    private $_joinTables = array();

    private $_q_where = array();

    private $_q;

    private $_limitfrom;

    private $_limitcount;

    private $_orderby;

    private $_ordertype;

    private $_connectionDatabase = null;

    /**
     * Кеш пустых объектов для метода _NewClassname()
     *
     * @see _NewClassname()
     * @var array
     */
    private static $_NewCacheArray = array();

    /**
     * Массив полей для заданной таблицы
     *
     * @var array
     */
    private static $_FieldArray = array();

    /**
     * Первичный ключ для заданной таблицы
     *
     * @var array
     */
    private static $_PrimaryKeyArray = array();

    /**
     * Не сохранять объекты при транзакции
     *
     * @var bool
     */
    private static  $_noValuesSave = false;

}