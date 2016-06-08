<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * событие для Sync
 *
 * @author    i.ustimenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Box_Sync implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        // синхронизируем данные в таблице settings
        $sync = new SQLObjectSync_Data(new XShopSettings());
        $sync->addData(
            array(
                'key' => 'box-parser-email',
            ),
            array(
                'value' => 'box@webproduction.ua',
            ),
            array(
                'name' => 'Уведомления OneBox: обратный email',
                'type' => 'string',
                'tabname' => 'Уведомления OneBox по email',
                'description' => 'Почта, на которую можно отправлять комментарии к задачам и заказам'
            )
        );

        $sync->addData(
            array(
                'key' => 'box-parser-email-projectid',
            ),
            array(
                'value' => '',
            ),
            array(
                'name' => 'Уведомления OneBox: проект для неизвестных email',
                'type' => 'string',
                'tabname' => 'Уведомления OneBox по email',
                'description' => 
                'Номер проекта, в который поставится задача, если будет неизвестное письмо на ящик box@'
            )
        );

        $sync->addData(
            array(
                'key' => 'box-parser-email-workflowid',
            ),
            array(
                'value' => '',
            ),
            array(
                'name' => 'Уведомления OneBox: бизнес-процесс для неизвестных email',
                'type' => 'string',
                'tabname' => 'Уведомления OneBox по email',
                'description' => 'Номер БП, по которому поставится задача, если будет неизвестное письмо на ящик box@'
            )
        );

        $sync->addData(
            array(
                'key' => 'box-parser-email-managerid',
            ),
            array(
                'value' => '',
            ),
            array(
                'name' => 'Уведомления OneBox: ID сотрудника для неизвестных email',
                'type' => 'string',
                'tabname' => 'Уведомления OneBox по email',
                'description' => 'Номер сотрудника, на которого поставится задача при неизвестном письме на box@'
            )
        );

        $signature = "<hr />\nС уважением, [name]<br>\n[company]<br>\n<br>\n";
        //$signature .= "Отправлено через OneBox - систему управления бизнесом, больше чем crm и erp.<br />\n";
        //$signature .= "<a href=\"http://webproduction.ua/onebox\">http://webproduction.ua/onebox</a><br />";
        $sync->addData(
            array(
                'key' => 'box-email-signature',
            ),
            array(
                'value' => $signature,
            ),
            array(
                'name' => 'Общая подпись',
                'type' => 'html',
                'tabname' => 'Уведомления: шаблоны',
            )
        );

        $sync->addData(
            array(
                'key' => 'box-slogan-email-signature',
            ),
            array(
                'value' => '1',
            ),
            array(
                'name' => 'Вставлять в конец письма подпись от box',
                'type' => 'boolean',
                'tabname' => 'Уведомления: шаблоны',
            )
        );

        $sync->addData(
            array(
                'key' => 'calendar-show-issue',
            ),
            array(
                'value' => serialize(array('name', 'project')),
            ),
            array(
                'name' => 'Какие данные о задаче отображать в календаре',
                'type' => 'select-calendar-issue',
                'tabname' => 'Внешний вид в админ-панели',
                'description' => ''
            )
        );

        $sync->addData(
            array(
                'key' => 'calendar-show-issue-priority',
            ),
            array(
                'value' => 0,
            ),
            array(
                'name' => 'Сортировать задачи в календаре по времени, иначе по приоритетам',
                'type' => 'boolean',
                'tabname' => 'Внешний вид в админ-панели',
                'description' => ''
            )
        );
        $sync->sync();
        
        
        KPIService::Get()->addKPI('BoxKPI_CallDay', 'Количество звонков за день');
        KPIService::Get()->addKPI('BoxKPI_CallDay', 'Количество входящих звонков за день', 1);
        KPIService::Get()->addKPI('BoxKPI_CallDay', 'Количество исходящих звонков за день', -1);

        KPIService::Get()->addKPI('BoxKPI_CallMonth', 'Количество звонков за месяц');
        KPIService::Get()->addKPI('BoxKPI_CallMonth', 'Количество входящих звонков за месяц', 1);
        KPIService::Get()->addKPI('BoxKPI_CallMonth', 'Количество исходящих звонков за месяц', -1);

        // email
        KPIService::Get()->addKPI('BoxKPI_EmailDay', 'Количество email за день');
        KPIService::Get()->addKPI('BoxKPI_EmailDay', 'Количество входящих email за день', 1);
        KPIService::Get()->addKPI('BoxKPI_EmailDay', 'Количество исходящих email за день', -1);

        KPIService::Get()->addKPI('BoxKPI_EmailMonth', 'Количество email за месяц');
        KPIService::Get()->addKPI('BoxKPI_EmailMonth', 'Количество входящих email за месяц', 1);
        KPIService::Get()->addKPI('BoxKPI_EmailMonth', 'Количество исходящих email за месяц', -1);

        // issue
        KPIService::Get()->addKPI('BoxKPI_IssueActive', 'Количество активных задач на сотруднике (всего)');
        KPIService::Get()->addKPI('BoxKPI_IssueActiveDay', 'Количество активных задач на сотруднике на день');
        KPIService::Get()->addKPI('BoxKPI_IssueActiveMonth', 'Количество активных задач на сотруднике на месяц');
        KPIService::Get()->addKPI('BoxKPI_IssueDoneDay', 'Количество закрытых задач на сотруднике за день');
        KPIService::Get()->addKPI('BoxKPI_IssueDoneMonth', 'Количество закрытых задач на сотруднике за месяц');
        KPIService::Get()->addKPI('BoxKPI_IssueHot', 'Количество просроченных задач на сотруднике (всего)');

        // order
        KPIService::Get()->addKPI('BoxKPI_OrderActive', 'Количество активных заказов на сотруднике (всего)');

        // project
        KPIService::Get()->addKPI('BoxKPI_ProjectActive', 'Количество активных проектов на сотруднике (всего)');
        KPIService::Get()->addKPI(
            'BoxKPI_OrderSaleProductCountMonth',
            'Проданный продукт (количество) сотрудником за месяц'
        );
        KPIService::Get()->addKPI(
            'BoxKPI_OrderSaleProductSumMonth',
            'Проданный продукт (сумма) сотрудником за месяц'
        );
        KPIService::Get()->addKPI(
            'BoxKPI_OrderSaleProductMarginMonth',
            'Проданный продукт (маржа) сотрудником за месяц'
        );
        KPIService::Get()->addKPI(
            'BoxKPI_OrderSaleBrandCountMonth',
            'Проданный бренд (количество продуктов) сотрудником за месяц'
        );
        KPIService::Get()->addKPI(
            'BoxKPI_OrderSaleBrandSumMonth',
            'Проданный бренды (сумма продуктов) сотрудником за месяц'
        );
        KPIService::Get()->addKPI(
            'BoxKPI_OrderSaleBrandMarginMonth',
            'Проданный бренды (маржа продуктов) сотрудником за месяц'
        );
        KPIService::Get()->addKPI(
            'BoxKPI_OrderSaleCategoryCountMonth',
            'Проданная категория (количество продуктов) сотрудником за месяц'
        );
        KPIService::Get()->addKPI(
            'BoxKPI_OrderSaleCategorySumMonth',
            'Проданная категория (сумма продуктов) сотрудником за месяц'
        );
        KPIService::Get()->addKPI(
            'BoxKPI_OrderSaleCategoryMarginMonth',
            'Проданная категория (маржа продуктов) сотрудником за месяц'
        );
    }

}