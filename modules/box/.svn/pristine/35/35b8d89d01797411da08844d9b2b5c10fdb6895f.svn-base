<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class ReportService extends ServiceUtils_AbstractService {

    /**
     * Получить все отчеты
     *
     * @return ShopReport
     */
    public function getReportAll() {
        return $this->getObjectsAll('ShopReport');
    }

    /**
     * Получить отчет по ID
     *
     * @param int $id
     *
     * @return ShopReport
     */
    public function getReportByID($id) {
        return $this->getObjectByID($id, 'ShopReport');
    }

    /**
     * Добавить отчет
     *
     * @param string $name
     * @param string $row
     * @param array $columnArray
     *
     * @return ShopReport
     */
    public function addReport($name, $row, $columnArray) {
        try {
            SQLObject::TransactionStart();

            if (!$name) {
                throw new ServiceUtils_Exception('report-name');
            }

            $rowAllArray = $this->getRowArray();
            if (!$row || !isset($rowAllArray[$row])) {
                throw new ServiceUtils_Exception('report-row');
            }

            $columnAllArray = $this->getColumnArray();
            foreach ($columnArray as $k => $columnKey) {
                if (!isset($columnAllArray[$columnKey])) {
                    unset($columnArray[$k]);
                }
            }

            if (!$columnArray) {
                throw new ServiceUtils_Exception('report-column');
            }

            $report = new ShopReport();
            $report->setName($name);
            $report->setRow($row);
            $report->setColumns(implode(';', $columnArray));
            $report->insert();

            SQLObject::TransactionCommit();

            return $report;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Редактировать отчет
     *
     * @param ShopReport $report
     * @param string $name
     */
    public function editReport(ShopReport $report, $name) {
        try {
            SQLObject::TransactionStart();

            if (!$name) {
                throw new ServiceUtils_Exception('report-name');
            }

            $report->setName($name);
            $report->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить отчет
     *
     * @param ShopReport $report
     */
    public function deleteReport(ShopReport $report) {
        try {
            SQLObject::TransactionStart();

            $report->delete();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить возможные строки отчета
     *
     * @return array
     */
    public function getRowArray() {
        $rowAllArray = array(
        'contact-all' => 'Контакты',
        'contact-client' => 'Клиенты',
        'contact-supplier' => 'Поставщики',
        'contact-employer' => 'Сотрудники',
        'contact-mycompany' => 'Мои компании',
        'order-source' => 'Источники заказов',
        'contact-source' => 'Источники контактов',
        'order-workflow' => 'Бизнес-процессы',
        'order-status' => 'Этапы бизнес-процессов'
        );

        return $rowAllArray;
    }

    /**
     * Получить возможные колонки отчета
     *
     * @return array
     */
    public function getColumnArray() {
        $columnAllArray = array(
        'order-count' => 'Количество заказов',
        //'order-avg' => 'Среднее заказов (AVG)',
        'order-sum-total' => 'Сумма заказов',
        'order-sum-avg' => 'Средний чек заказов',
        'issue-count' => 'Количество задач',
        //'issue-avg' => 'Среднее количество задач',
        'event-count' => 'Количество событий',
        'event-email-count' => 'Количество событий писем',
        'event-email-in-count' => 'Количество событий писем входящих',
        'event-email-out-count' => 'Количество событий писем исходящих',
        'event-call-count' => 'Количество событий звонков',
        'event-call-in-count' => 'Количество событий звонков входящих',
        'event-call-out-count' => 'Количество событий звонков исходящих',
        'event-meeting-count' => 'Количество событий встреча',
        'payment-count' => 'Количество платежей',
        'payment-sum-total' => 'Сумма платежей',
        'payment-sum-avg' => 'Средний чек платежа',
        'probation-count' => 'Количество ожидаемых платежей',
        'probation-sum' => 'Сумма ожидаемых платежей',
        'balance' => 'Баланс',
        'balance-plus' => 'Переплата',
        'balance-minus' => 'Долг'
        );

        return $columnAllArray;
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return ReportService
     */
    public static function Get() {
        if (!self::$_Instance) {
            $classname = self::$_Classname;
            if ($classname) {
                self::$_Instance = new $classname();
            } else {
                self::$_Instance = new self();
            }
        }
        return self::$_Instance;
    }

    /**
     * Задать класс сервиса.
     * override-метод.
     *
     * @param string $classname
     */
    public static function Set($classname) {
        self::$_Classname = $classname;
        self::$_Instance = null;
    }

    /**
     * Подменяемый объект сервиса
     *
     * @var ReportService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}