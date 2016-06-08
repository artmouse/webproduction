<?php

class Box_Interface_Block_Build implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        // добавляем блоки для формирования структуры заказа
        Interface_Block_Loader::Get()->addBlock('box-admin-block-name', 'Название');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-description', 'Описание');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-stage-instruction', 'Инструкция к этапу');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-stage-history', 'История статусов');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-client-info-full', 'Информация о контакте полная');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-active-order', 'Список активных заказов');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-product-list', 'Продукты', 8);
        Interface_Block_Loader::Get()->addBlock('box-admin-block-project-tree', 'Дерево проекта');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-issue-structure', 'Структура');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-comment-list', 'Лента комментариев', 10);
        Interface_Block_Loader::Get()->addBlock('box-admin-block-info', 'Информация полная');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-client-info', 'Информация о контакте');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-status-info', 'Информация о статусе');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-graph-activities', 'График активности проекта');
        Interface_Block_Loader::Get()->addBlock(
            'box-admin-block-graph-load',
            'График нагрузки на исполнителей проекта'
        );
        Interface_Block_Loader::Get()->addBlock('box-admin-block-workflow-visual', 'Визуализация бизнес-процесса');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-product-list-short', 'Продукты сокращенный');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-files', 'Вложенные файлы');

        Interface_Block_Loader::Get()->addBlock('box-admin-block-make-result', 'Внести результат');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-write-letter', 'Написать письмо');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-call', 'Позвонить');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-info-short', 'Короткая информация о заказе');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-user-card-fill', 'Заполнить карточку контакта');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-issues-add', 'Поставить задачи');

        Interface_Block_Loader::Get()->addBlock('box-admin-block-issues-like', 'Похожие задачи');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-my-order', 'Мои заказы');
        Interface_Block_Loader::Get()->addBlock('box-admin-block-project-order', 'Список задач проекта');

        Interface_Block_Loader::Get()->addBlock(
            'box-productview-order-block',
            'Список просмотренных клиентом продуктов'
        );

        Interface_Block_Loader::Get()->addBlock('box-timelog-order-block', 'Затраченое время');

    }

}