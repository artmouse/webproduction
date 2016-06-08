<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class Shop_ContentTable extends Forms_ContentTable {

    public function __construct($datasource) {
        parent::__construct($datasource);
        $this->getStepper()->setFileHTML(dirname(__FILE__).'/Shop_ContentTable_Stepper.html');
        $this->getStepper()->setTranslateArray(Shop::Get()->getTranslateService()->getTranslateArray());
        $this->setFileHTML(dirname(__FILE__).'/Shop_ContentTable.html');
        $this->setCSSClassName('shop-table');

        $this->setRow(new Shop_ContentTableRow());

        $filter = Engine::GetContentDriver()->getContent('datasource-filter');
        $filter->setValue('datasource', $datasource);
        $this->setValue('filter', $filter->render());
        $this->_makeVisibleFildsArray();
        $this->_checkLevelUserAuthorization();
    }

    public function disableExports() {
        $this->_disableExports = true;
    }

    public function makeFiltersArray() {
        $operationsArray = array();
        $operationsArray[] = 'equals';
        $operationsArray[] = 'lt';
        $operationsArray[] = 'gt';
        $operationsArray[] = 'lte';
        $operationsArray[] = 'gte';
        $operationsArray[] = 'search'; // like
        $operationsArray[] = 'searchstart'; // like starts
        $operationsArray[] = 'searchend'; // like ends

        $filtersArray = array();
        $filtersSavesArray = array();
        $arguments = Engine::GetURLParser()->getArguments();

        // получаем connection для escape-функции
        $connection = ConnectionManager::Get()->getConnectionDatabase();

        foreach ($arguments as $k => $v) {
            // массив только по фильтрам
            if (preg_match('/^filter(\d+)_/uis', $k)) {
                $filtersSavesArray[$k] = $v;
            }

            if (preg_match('/^filter(\d+)_key$/uis', $k, $r)) {
                try {
                    $key = $v;
                    $type = @$arguments['filter'.$r[1].'_type'];
                    $value = @$arguments['filter'.$r[1].'_value'];

                    if (!in_array($type, $operationsArray)) {
                        $type = $operationsArray[0];
                    }

                    // пропускаем пустые значения
                    if ($value === '' || $value === false) {
                        continue;
                    }

                    // @todo: переписать на обработчики
                    // @todo: refactoring

                    if ($type == 'equals') {
                        $field = $this->getDataSource()->getField($key);
                        if ($field instanceof Forms_ContentFieldInt
                        || $field instanceof Forms_ContentFieldNumeric
                        ) {
                            $value = (float) $value;
                        } else {
                            $value = $connection->escapeString($value);
                            $value = "'{$value}'";
                        }

                        $filter = new Forms_FilterObject(
                            $key,
                            "= $value",
                            true
                        );
                    } elseif ($type == 'lt') {
                        $field = $this->getDataSource()->getField($key);
                        if ($field instanceof Forms_ContentFieldInt
                        || $field instanceof Forms_ContentFieldNumeric
                        ) {
                            $value = (float) $value;
                        } elseif ($field instanceof Forms_ContentFieldDatetime) {
                            $value = DateTime_Corrector::CorrectDateTime($value);
                            $value = "'{$value}'";
                        } else {
                            $value = $connection->escapeString($value);
                            $value = "'{$value}'";
                        }

                        $filter = new Forms_FilterObject(
                            $key,
                            "<= $value",
                            true
                        );
                    } elseif ($type == 'lte') {
                        $field = $this->getDataSource()->getField($key);
                        if ($field instanceof Forms_ContentFieldInt
                        || $field instanceof Forms_ContentFieldNumeric
                        ) {
                            $value = (float) $value;
                        } elseif ($field instanceof Forms_ContentFieldDatetime) {
                            $value = DateTime_Corrector::CorrectDateTime($value);
                            $value = "'{$value}'";
                        } else {
                            $value = $connection->escapeString($value);
                            $value = "'{$value}'";
                        }

                        $filter = new Forms_FilterObject(
                            $key,
                            "<= $value",
                            true
                        );
                    } elseif ($type == 'gt') {
                        $field = $this->getDataSource()->getField($key);
                        if ($field instanceof Forms_ContentFieldInt
                        || $field instanceof Forms_ContentFieldNumeric
                        ) {
                            $value = (float) $value;
                        } elseif ($field instanceof Forms_ContentFieldDatetime) {
                            $value = DateTime_Corrector::CorrectDateTime($value);
                            $value = "'{$value}'";
                        } else {
                            $value = $connection->escapeString($value);
                            $value = "'{$value}'";
                        }

                        $filter = new Forms_FilterObject(
                            $key,
                            "> $value",
                            true
                        );
                    } elseif ($type == 'gte') {
                        $field = $this->getDataSource()->getField($key);
                        if ($field instanceof Forms_ContentFieldInt
                        || $field instanceof Forms_ContentFieldNumeric
                        ) {
                            $value = (float) $value;
                        } elseif ($field instanceof Forms_ContentFieldDatetime) {
                            $value = DateTime_Corrector::CorrectDateTime($value);
                            $value = "'{$value}'";
                        } else {
                            $value = $connection->escapeString($value);
                            $value = "'{$value}'";
                        }

                        $filter = new Forms_FilterObject(
                            $key,
                            ">= $value",
                            true
                        );
                    } elseif ($type == 'search') {
                        $value = str_replace(' ', '%', $value);

                        $filter = new Forms_FilterObject(
                            $key,
                            "LIKE '%".$connection->escapeString($value)."%'",
                            true
                        );
                    } elseif ($type == 'searchstart') {
                        $value = str_replace(' ', '%', $value);

                        $filter = new Forms_FilterObject(
                            $key,
                            "LIKE '".$connection->escapeString($value)."%'",
                            true
                        );
                    } elseif ($type == 'searchend') {
                        $value = str_replace(' ', '%', $value);

                        $filter = new Forms_FilterObject(
                            $key,
                            "LIKE '%".$connection->escapeString($value)."'",
                            true
                        );
                    }

                    $filtersArray[] = $filter;
                } catch (Exception $filterException) {

                }
            }
        }

        $tablelike = Engine::GetURLParser()->getArgumentSecure('tablelike');
        if ($tablelike) {
            $filter = new Forms_FilterObject(
                'tablelike',
                $tablelike,
                true
            );
            $filtersArray[] = $filter;
        }

        // сохраняем фильтр в сессию/COOKIE
        $_SESSION['filters'.Engine::Get()->getRequest()->getContentID()] = serialize($filtersSavesArray);

        return $filtersArray;
    }

    public function render($assignsArray = array()) {
        $assignsArray;
        $user = Shop::Get()->getUserService()->getUser();

        $this->setValue('disableExports', $this->_disableExports);
        $this->setValue('isUserAdmin', $this->_isUserAdmin);
        $this->setValue('canExport', $user->isAllowed('table-export'));

        $this->setValue(
            'urlexportcsv', Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('export-csv' => 1))
        );
        $this->setValue(
            'urlexportxls', Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('export-xls' => 1))
        );
        $this->setValue(
            'urlexportxml', Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('export-xml' => 1))
        );

        // прячим лишние колонки
        $datasource = $this->getDataSource();
        $datasourceName = get_class($datasource);

        $fieldsArray = $this->getFieldsArray();
        foreach ($fieldsArray as $field) {
            try {
                if (isset($this->_visibleFildsArray[$field->getKey()])
                    && !$this->_visibleFildsArray[$field->getKey()]
                    && $field->getKey() != $datasource->getFieldPrimary()->getKey()
                ) {
                    $this->removeField($field->getKey());
                }
            } catch (Exception $e) {

            }
        }

        $this->setTranslateArray(Shop::Get()->getTranslateService()->getTranslateArray());

        $result = parent::render();

        // exports
        $exportCSV = Engine::GetURLParser()->getArgumentSecure('export-csv');
        $exportXML = Engine::GetURLParser()->getArgumentSecure('export-xml');
        $exportXLS = Engine::GetURLParser()->getArgumentSecure('export-xls');

        // export selected data to CSV
        if (!$this->_disableExports &&
            ($this->_isUserAdmin || $user->isAllowed('table-export')) &&
            ($exportCSV || $exportXLS || $exportXML)
        ) {
            $data = $this->makeDataSourceData(
                true, // with filters
                true, // with sorts
                'all', // without pages
                false // without count
            );

            $filename = 'export '.date('Y-m-d H:i:s').' '.get_class($this->getDataSource());
            $filename = str_replace('DataSource_', '', $filename);
            $filename = str_replace('Datasource_', '', $filename);

            if ($exportCSV) {
                PackageLoader::Get()->import('CSV');
                $csv = CSV_Creator::CreateFromArray($data);
                header('Content-type: text/csv');
                header('Content-Disposition: attachment; filename="'.$filename.'.csv"');
                print $csv->__toString();
                exit();
            }

            if ($exportXLS) {
                PackageLoader::Get()->import('XLS');
                $xls = XLS_Creator::CreateFromArray($data);
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment; filename="'.$filename.'.xls"');
                print $xls->__toString();
                exit();
            }

            if ($exportXML) {
                PackageLoader::Get()->import('XML');
                $xml = XML_Creator::CreateFromArray(array('table' => array('row' => $data)));
                header('Content-type: text/xml');
                header('Content-Disposition: attachment; filename="'.$filename.'.xml"');
                print $xml->__toString();
                exit();
            }
        }

        return $result;
    }

    /**
     * Получить количество строк на одной странице
     *
     * @return int
     */
    public function getLinesOnPage() {
        // пытаемся достать параметр из COOKIE
        $rowsCount = (int) @$_COOKIE['rowscount_'.get_class($this->getDataSource())];
        if (!$rowsCount && $rowsCount <= 0) {
            return 50;
        }
        if ($rowsCount <= 10) {
            $rowsCount = 10;
        }
        if ($rowsCount >= 100) {
            $rowsCount = 100;
        }
        return $rowsCount;
    }

    /**
     * Записываем в масив видимость колонок
     */
    private function _makeVisibleFildsArray() {
        $user = Shop::Get()->getUserService()->getUser();
        $link = new XShopTableColumn();
        $link->setUserid($user->getId());
        $link->setDatasource(get_class($this->getDataSource()));
        while ($x = $link->getNext())
            $this->_visibleFildsArray[$x->getKey()] = $x->getVisible();
    }
    
    /**
     * Является ли юзер админом 
     */
    private function _checkLevelUserAuthorization() {
        try {
            $user = Shop::Get()->getUserService()->getUser();
            if ($user && ($user->getLevel() == 3)) {
                $this->_isUserAdmin = true;
            }
        } catch (Exception $e) {
            
        }
    }

    private $_isUserAdmin = false;

    private $_disableExports = false;

    private $_visibleFildsArray = array();

}