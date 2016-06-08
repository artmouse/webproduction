<?php

class Storage_Action_Block_Build implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        WorkflowStatusLoader::Get()->addBlock(
            'Приходовать заказ на склад',
            'storage-order-status-action-block-debit-order-auto'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Снять резерв товара на складе',
            'storage-order-status-action-block-reserve-unset'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Вернуть товар на склад',
            'storage-order-status-action-block-product-return'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Продать заказ со склада',
            'storage-order-status-action-block-order-sale-auto'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Резервировать товар на складе',
            'storage-order-status-action-block-product-reserve-auto'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Производство',
            'storage-order-status-action-block-production-passport'
        );
    }

}