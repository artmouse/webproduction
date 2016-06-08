<?php
class calendar_block_load_ajax extends Engine_Class {

    public function process() {
        $argumentArray = $this->getArgumentSecure('arguments', 'array');
        $whereArray = $this->getArgumentSecure('where', 'array');

        // получаем задачи
        $issues = IssueService::Get()->getIssuesAll($this->getUser());
        
        // фильтруем задачи согласно переданным аргументам и where
        foreach ($argumentArray as $argument) {
            if (isset($argument['value'])) {
                $issues->filterField($argument['name'], $argument['value']);
            }
        }

        $connection = ConnectionManager::Get()->getConnectionDatabase();

        foreach ($whereArray as $where) {
            if (isset($where['value'])) {
                $whereData = (Array) json_decode($where['value']);
                if ($whereData['v']) {
                    $field = $whereData['f'];
                    $query = $connection->escapeString($whereData['v']);

                    $query = str_replace('\r', '', $query);
                    $query = str_replace('\n', '', $query);

                    $issues->addWhere($field, $query, $whereData['o']);
                }
            }
        }

        // Календарь
        $render = Engine::GetContentDriver()->getContent('calendar-block');
        $render->setValue('issue', $issues);
        echo $render->render();
    }

}