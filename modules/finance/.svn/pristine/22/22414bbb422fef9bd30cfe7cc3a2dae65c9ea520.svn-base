<?php

class Finance_Action_Block_Build implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        WorkflowStatusLoader::Get()->addBlock(
            'Сформировать ожидаемый платеж',
            'finance-expected-percent-amount',
            'Процент ожидаемой суммы" (указывается от 0 до 100)'
        );
    }

}