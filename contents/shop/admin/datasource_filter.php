<?php
class datasource_filter extends Engine_Class {

    /**
     * Получить источник данных
     *
     * @return Forms_ADataSource
     */
    private function _getDatasource() {
        return $this->getValue('datasource');
    }

    public function process() {
        // получаем D.S.
        $datasource = $this->_getDatasource();

        // сохраняем колонки и настройки строк
        if ($this->getControlValue('columnsave')) {
            try {
                $columnsArray = (array) $this->getControlValue('columns');

                // удаляем все настройки
                $link = new XShopTableColumn();
                $link->setUserid($this->getUser()->getId());
                $link->setDatasource(get_class($datasource));
                $link->delete(true);

                // вставляем новые записи
                $fieldsArray = $datasource->getFieldsArray();
                foreach ($fieldsArray as $field) {
                    $key = $field->getKey();
                    $visible = (int) in_array($key, $columnsArray);

                    // основные поля нельзя скрывать
                    if ($key == $datasource->getFieldPrimary()->getKey()) {
                        $visible = 1;
                    }

                    try {
                        if ($key == $datasource->getFieldPreview()->getKey()) {
                            $visible = 1;
                        }
                    } catch (Exception $prEx) {

                    }

                    $link = new XShopTableColumn();
                    $link->setUserid($this->getUser()->getId());
                    $link->setDatasource(get_class($datasource));
                    $link->setKey($key);
                    $link->setVisible($visible);
                    $link->insert();
                }
            } catch (Exception $ge) {

            }

            // сохраняем настройки строк
            // (сохнаняем в куки)
            $reloadPage = false;
            $cookie_etime = time() + 72000*60;

            $rowsCount = (int) $this->getArgumentSecure('rowscount');
            if ($rowsCount) {
                if ($rowsCount > 100) {
                    $rowsCount = 100;
                }
                setcookie('rowscount_'.get_class($datasource), $rowsCount, $cookie_etime, '/');
                $reloadPage = true;
            }

            try {
                $rowsSort = $this->getArgument('rowssort');
                setcookie('rowssort_'.get_class($datasource), $rowsSort, $cookie_etime, '/');
                $reloadPage = true;
            } catch (Exception $e) {

            }

            try {
                $rowsSortType = $this->getArgument('rowssorttype');
                setcookie('rowssorttype_'.get_class($datasource), $rowsSortType, $cookie_etime, '/');
                $reloadPage = true;
            } catch (Exception $e) {

            }

            if ($reloadPage) {
                header('Location: .');
                exit();
            }
        }

        $fieldsArray = $datasource->getFieldsArray();
        $a = array();
        // записываем в масив видимость колонок
        $this->_makeVisibleFildsArray();
        foreach ($fieldsArray as $field) {
            $filter = strstr($field->getKey(), "filter");
            $seotext = strstr($field->getKey(), "seo");
            if ($field->getKey() == "unitbox"
            || $field->getKey() == "barcode"
            || $field->getKey() == "warranty"
            || $filter
            || $seotext) {
                continue;
            }
            $dsArray = array();

            try {
                // для юзеров пропускам
                if ($datasource instanceof Datasource_Users) {
                    throw new ServiceUtils_Exception();
                }

                $ds = clone $field->getDatasource();
                $cnt = $ds->select(false, false, false, false, false, true);
                if ($cnt > 100) {
                    throw new ServiceUtils_Exception();
                }

                $dsData = $ds->select();
                foreach ($dsData as $dsX) {
                    $dsArray[] = array(
                    'key' => $dsX[$ds->getFieldPrimary()->getKey()],
                    'value' => $dsX[$ds->getFieldPreview()->getKey()],
                    );
                }
            } catch (Exception $e) {

            }

            if ($field instanceof Forms_ContentFieldCheckbox) {
                $dsArray[] = array(
                'key' => 1,
                'value' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_yes'),
                );
                $dsArray[] = array(
                'key' => 0,
                'value' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_no'),
                );
            }

            $visible = true; // по умолчанию колонка видна
            if (isset($this->_visibleFildsArray[$field->getKey()])) {
                $visible = $this->_visibleFildsArray[$field->getKey()];
            }

            try {
                $primary =
                ($field->getKey() == $datasource->getFieldPrimary()->getKey()
                || $field->getKey() == $datasource->getFieldPreview()->getKey()
                );
            } catch (Exception $prEx) {
                $primary = false;
            }

            $a[$field->getKey()] = array(
            'key' => $field->getKey(),
            'name' => $field->getName(),
            'datasouceArray' => $dsArray,
            'visible' => $visible,
            'primary' => $primary,
            'sortable' => $field->getSortable(),
            );
        }
        $this->setValue('fieldsArray', $a);

        // передаем количество строк на странице
        $rowsCount = (int) @$_COOKIE['rowscount_'.get_class($datasource)];
        if (!$rowsCount) {
            $rowsCount = 50;
        }
        if ($rowsCount < 10) {
            $rowsCount = 10;
        }
        if ($rowsCount > 100) {
            $rowsCount = 100;
        }
        $this->setValue('rowscount', $rowsCount);

        // передаем сортировку строк на странице
        $rowsSort = @$_COOKIE['rowssort_'.get_class($datasource)];
        $this->setValue('rowssort', $rowsSort);

        $rowsSortType = @$_COOKIE['rowssorttype_'.get_class($datasource)];
        $this->setValue('rowssorttype', $rowsSortType);

        // разрешены ли фильтры на странице
        $this->setValue('aclFilters', $this->getUser()->isAllowed('filters'));
    }

    /**
     * Записываем в масив видимость колонок
     */
    private function _makeVisibleFildsArray() {
        $link = new XShopTableColumn();
        $link->setUserid($this->getUser()->getId());
        $link->setDatasource(get_class($this->_getDatasource()));
        while ($x = $link->getNext())
        $this->_visibleFildsArray[$x->getKey()] = $x->getVisible();
    }

    private $_visibleFildsArray = array();

}