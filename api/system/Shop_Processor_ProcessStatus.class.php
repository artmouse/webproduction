<?php

class Shop_Processor_ProcessStatus {

    public function process() {
        // автоматическое открытие или закрытие задач если статус closed 0/1
        WorkflowService::Get()->processStatusClosed();
        WorkflowService::Get()->processStatusOpened();
    }

}