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
 * Подгрузка ACL по требованию
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Finance_ACL implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        Shop::Get()->getAclService()->addACLPermission('finance', 'Финансовый учет');

        $accounts = FinanceService::Get()->getAccountsAll();
        while ($x = $accounts->getNext()) {
            Shop::Get()->getAclService()->addACLPermission(
                'finance-account-'.$x->getId().'-view',
                'Финансовый учет :: Аккаунт '.$x->getName().' - просмотр платежей'
            );

            Shop::Get()->getAclService()->addACLPermission(
                'finance-account-'.$x->getId().'-control',
                'Финансовый учет :: Аккаунт '.$x->getName().' - редактирование платежей'
            );

            Shop::Get()->getAclService()->addACLPermission(
                'finance-account-'.$x->getId().'-delete',
                'Финансовый учет :: Аккаунт '.$x->getName().' - удаление платежей'
            );
        }

        Shop::Get()->getAclService()->addACLPermission(
            'finance-report-category',
            'Финансовый учет :: Отчет по категориям'
        );
        Shop::Get()->getAclService()->addACLPermission(
            'finance-report-account',
            'Финансовый учет :: Отчет по аккаунтам'
        );
        Shop::Get()->getAclService()->addACLPermission(
            'finance-report-balance',
            'Финансовый учет :: Отчет Баланс по клиенту'
        );
        Shop::Get()->getAclService()->addACLPermission(
            'finance-invoice',
            'Финансовый учет :: Инвойсы'
        );
    }

}