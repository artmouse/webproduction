<?php

class Shop_Action_Block_Build implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        
        WorkflowStatusLoader::Get()->addBlock(
            'Закрыть задачу',
            'shop-order-status-action-block-order-closed',
            'Считать заказ закрытым'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Ожидать проверки',
            'shop-order-status-action-block-awaiting-verification'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Указать срок статуса',
            'shop-order-status-action-block-term'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Изменить статус на',
            'shop-order-status-action-block-status-change'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Отправить уведомление по смс клиенту',
            'shop-order-status-action-block-notice-client-sms'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Отправить уведомление по смс менеджеру',
            'shop-order-status-action-block-notice-manager-sms'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Отправить уведомление по email клиенту',
            'shop-order-status-action-block-notice-client-email'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Отправить уведомление по email менеджеру',
            'shop-order-status-action-block-notice-manager-email'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Отправить смс уведомление всем контактам этого БП',
            'shop-order-status-action-block-notification-sms-clients-all'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Массовая рассылка email по всем контактам задачи/заказа/проекта',
            'shop-order-status-action-block-notification-email-clients-all'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Выгрузить заказ в CSV',
            'shop-order-status-action-block-upload-csv'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Выгрузить заказ в XML',
            'shop-order-status-action-block-upload-xml'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Продать заказ',
            'shop-order-status-action-block-order-saled',
            'Считать заказ проданным'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Отгрузить заказ',
            'shop-order-status-action-block-order-shipped',
            'Считать заказ отгруженным'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Требовать содержание',
            'shop-order-status-action-block-content-need',
            'Необходимо содержание'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Регистрировать финансовое обязательство на сумму заказа в виде оплаты',
            'shop-order-status-action-block-payment-need',
            'Стоимость заказа повлияет на баланс контакта (Требовать оплату. Должна быть оплата.)'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Регистрировать финансовое обязательство на сумму заказа в виде предоплаты',
            'shop-order-status-action-block-prepayment-need',
            'Стоимость заказа повлияет на баланс контакта (Требовать предоплату. Должна быть предоплата.)'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Проверка на выполнение подзадач',
            'shop-order-status-action-block-check-sub-issue'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Перенести дату выполнения (завершения) задачи',
            'shop-issue-status-action-day-move',
            'На сколько дней (можно ввести число, например 10 или -10)'
        );
    }

}