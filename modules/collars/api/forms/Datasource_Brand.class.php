<?php


class Datasource_Brand implements Events_IEventObserver {


    public function notify(Events_Event $event) {

        $datasource = $event->getObject();
        $field = new Forms_ContentFieldCheckbox('delete');
        $field->setName('Delete');
        $datasource->addField($field);




    }

}