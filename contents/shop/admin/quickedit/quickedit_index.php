<?php
class quickedit_index extends Engine_Class {

    public function process() {
        try {
            $datasourceName = $this->getArgument('datasource');
            $primaryKeyValue = $this->getArgument('pkvalue');
            $fieldKey = $this->getArgument('fieldkey');

            try {
                $value = $this->getArgument('value');

                // это сохранение
                $save = true;
            } catch (Exception $e) {
                // это вывод данных
                $save = false;
            }

            $datasource = Forms_DataSourceManager::Get()->getDataSource($datasourceName);
            $primaryKeyName = $datasource->getFieldPrimary()->getKey();
            $field = $datasource->getField($fieldKey);

            if ($save) {
                // save
                Engine::GetURLParser()->setArgument($fieldKey, $value);
                $datasource->update($primaryKeyValue, array($field));

                // rendew view
                $dataArray = $datasource->select(array(new Forms_FilterObject($primaryKeyName, $primaryKeyValue)));

                $field = $datasource->getField($fieldKey);
                echo $field->renderView(0, @$dataArray[0]);
                exit();
            } else {
                // render control
                $dataArray = $datasource->select(array(new Forms_FilterObject($primaryKeyName, $primaryKeyValue)));
                // Дополнительная проверка на CKEditor
                $render = preg_replace('#<script[^>]*>.*?</script>#is', '', $field->renderControl(@$dataArray[0][$fieldKey]));
                echo $render;
                exit();
            }
        } catch (Exception $ge) {

        }
    }

}