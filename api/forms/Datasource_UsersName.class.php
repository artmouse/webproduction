<?php

class Datasource_UsersName extends Datasource_Users {
    public function getFieldPreview() {
        return $this->getField('name');
    }
}