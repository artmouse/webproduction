<?php

class Box_Action_Block_Build implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        WorkflowStatusLoader::Get()->addBlock(
            'Указать ответственную роль',
            'box-order-status-action-block-role'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Копировать заказ за N дней до окончания',
            'box-order-status-action-block-order-copy'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Отправлять уведомление по email клиенту если нет оплаты',
            'box-order-status-action-block-client-notification-payment'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Закрыть заказ после даты завершения',
            'box-order-status-action-block-order-closed-by-dateto'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Добавить в затраченное время',
            'box-order-status-action-block-timelog-add'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Изменить ответственного',
            'box-order-status-action-block-manager-change',
            'При переходе в этот этап менять ответственного'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Перейти на следующий этап по истечению срока этапа',
            'box-order-status-action-block-status-change-auto',
            'Автоматически выполнять переход на следующий этап по истечению срока этапа'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Запретить смену этапа вручную',
            'box-order-status-action-block-status-change-by-hand',
            'Этап нельзя выбирать вручную'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Запретить уходить с этапа, пока не решены все подзадачи',
            'box-order-status-action-block-status-not-change',
            'С этапа нельзя уходить пока не решены все подзадачи данного этапа'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Уведомлять, если не было связи с клиентом',
            'box-order-status-action-block-notification-client-no-link'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Уведомлять, если не было связи с клиентом через звонки',
            'box-order-status-action-block-notification-client-no-link-phone'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Уведомлять, если не было связи с клиентом через email',
            'box-order-status-action-block-notification-client-no-link-email'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Автоматически начинать/повторять такую-же задачу через N дней',
            'box-order-status-action-block-auto-repeat-day'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Автоматически начинать/повторять такую-же задачу в день недели',
            'box-order-status-action-block-auto-repeat-week'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Автоматически начинать/повторять такую-же задачу в день месяца',
            'box-order-status-action-block-auto-repeat-month'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Перенести задачу на следующий день, если она не готова',
            'box-order-status-action-block-auto-transfer'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Создать подзадачу',
            'box-order-status-action-block-sub-workflow2'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Автоматически переключать на этап XXX через YYY дней',
            'box-order-status-action-block-auto-change-status-after-days'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Быстрый прыжок на другой статус',
            'box-order-status-action-block-switch-status'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Отправлять содержимое заказа на email клиента в заданное время',
            'box-order-status-action-block-client-order-send-email'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Создать напоминание о завершении срока задачи',
            'box-order-status-action-block-notify-overdue'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Создать подзадачу, если задача не выполнена в срок',
            'box-order-status-action-block-issue-no-on-time'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Уведомлять, если задача просрочена',
            'box-order-status-action-block-notice-overdue-dateto'
        );

        WorkflowStatusLoader::Get()->addBlock(
            'Автоматически переключать на этап XXX после даты завершения задачи/заказа/проекта',
            'box-order-status-action-block-change-status-overdue-dateto'
        );

    }

}