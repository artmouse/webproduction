<?php

class Datasource_UserType extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false) {
        parent::__construct($optionsArray);

        $this->addOption('all', 'Все');
        $this->addOption('person', 'Контакты');
        $this->addOption('company', 'Компании');

    }

}