<?php

class SupplierPrice_Action_Block_Build implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        WorkflowStatusLoader::Get()->addBlock(
            'Создать заказ поставщику',
            'shop-order-status-action-block-supplier-order'
        );
    }

}