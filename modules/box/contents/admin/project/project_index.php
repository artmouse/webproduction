<?php
class project_index extends Engine_Class {

    public function process() {
        $list = Engine::GetContentDriver()->getContent('issue-list');
        $list->setValue('datasource', new Datasource_Project());
        $this->setValue('block_issue', $list->render());
    }

}