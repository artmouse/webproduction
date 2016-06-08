<?php

class Document_Action_Block_Build implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        WorkflowStatusLoader::Get()->addBlock(
            'Запретить выбирать этот этап пока нет документов',
            'shop-order-status-action-block-document-need',
            'Необходимы документы'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Выписать документ',
            'document-order-status-action-block-document-writing'
        );
        
    }

}