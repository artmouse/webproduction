<?php

class Finance_ContentLoadObserver implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        // TPLs
        Engine::GetContentDataSource()->registerContent(
            'shop-finance-tpl',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/tpl_finance.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/tpl_finance.php',
                'filecss' => dirname(__FILE__) . '/contents/admin/tpl_finance.css',
                'filejs' => dirname(__FILE__) . '/contents/admin/tpl_finance.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('finance'),
            ),
            'override'
        );

        // Settings: аккаунты
        Engine::GetContentDataSource()->registerContent(
            'shop-finance-account',
            array(
                'title' => 'Аккаунты',
                'url' => '/admin/shop/finance/account/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/account/finance_account.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/account/finance_account.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '3',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-account-add',
            array(
                'title' => 'Аккаунты: редактирование',
                'url' => '/admin/shop/finance/account/add/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/account/finance_account_add.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/account/finance_account_add.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '3',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-account-control',
            array(
                'title' => 'Аккаунты: редактирование',
                'url' => '/admin/shop/finance/account/{key}/control/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/account/finance_account_control.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/account/finance_account_control.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '3',
            ),
            'override'
        );

        // Settings: категории платежей
        Engine::GetContentDataSource()->registerContent(
            'shop-finance-category',
            array(
                'title' => 'Категории',
                'url' => '/admin/shop/finance/category/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/category/finance_category.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/category/finance_category.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '3',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-category-control',
            array(
                'title' => 'Категории: редактирование',
                'url' => array(
                    '/admin/shop/finance/category/add/',
                    '/admin/shop/finance/category/{key}/'
                ),
                'filehtml' => dirname(__FILE__) . '/contents/admin/category/finance_category_control.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/category/finance_category_control.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '3',
            ),
            'override'
        );

        // Отчеты
        Engine::GetContentDataSource()->registerContent(
            'shop-finance-category-order',
            array(
                'title' => 'Отчет по категориям',
                'url' => '/admin/shop/finance/order/category/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/report/report_category.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/report/report_category.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('finance-report-category'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-account-order',
            array(
                'title' => 'Отчет по аккаунтам',
                'url' => '/admin/shop/finance/order/account/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/report/report_account.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/report/report_account.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('finance-report-account'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-report-client-balance',
            array(
                'title' => 'Отчет - Баланс по клиенту',
                'url' => '/admin/shop/finance/report/balance/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/report/report_balance.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/report/report_balance.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('finance-report-balance'),
            ),
            'override'
        );

        // Платежи
        Engine::GetContentDataSource()->registerContent(
            'shop-finance-index',
            array(
                'title' => 'Финансы',
                'url' => '/admin/shop/finance/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/finance_index.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/finance_index.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-payment-add',
            array(
                'title' => 'Финансы',
                'url' => '/admin/shop/finance/payment/add/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/payment/finance_payment_add.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/payment/finance_payment_add.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-payment-find',
            array(
                'title' => 'Финансы',
                'url' => '/admin/shop/finance/payment/find/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/payment/finance_payment_find.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/payment/finance_payment_find.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-payment-control',
            array(
                'title' => 'Финансы',
                'url' => '/admin/shop/finance/payment/{key}/control/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/payment/finance_payment_control.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/payment/finance_payment_control.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-payment-download',
            array(
                'url' => '/admin/shop/finance/payment/{key}/download/',
                'filephp' => dirname(__FILE__) . '/contents/admin/payment/finance_payment_download.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-payment-block',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/payment/finance_payment_block.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/payment/finance_payment_block.php',
                'filejs' => dirname(__FILE__) . '/contents/admin/payment/finance_payment_block.js',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-payment-list',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/payment/finance_payment_list.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/payment/finance_payment_list.php',
                'level' => '2',
            ),
            'override'
        );

        // Invoices
        Engine::GetContentDataSource()->registerContent(
            'shop-finance-invoice-index',
            array(
                'title' => 'Счета',
                'url' => array('/admin/shop/finance/invoice/list/', '/admin/shop/finance/invoice/list/{linkkey}/'),
                'filehtml' => dirname(__FILE__) . '/contents/admin/invoice/invoice_index.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/invoice/invoice_index.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('finance-invoice'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-invoice-view',
            array(
                'title' => 'Счета',
                'url' => '/admin/shop/finance/invoice/{id}/view/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/invoice/invoice_view.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/invoice/invoice_view.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('finance-invoice'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-invoice-add',
            array(
                'title' => 'Счета',
                'url' => '/admin/shop/finance/invoice/add/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/invoice/invoice_add.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/invoice/invoice_add.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('finance-invoice'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-invoice-edit',
            array(
                'title' => 'Счета',
                'url' => '/admin/shop/finance/invoice/{id}/edit/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/invoice/invoice_edit.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/invoice/invoice_edit.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('finance-invoice'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-invoice-delete',
            array(
                'title' => 'Счета',
                'url' => '/admin/shop/finance/invoice/{id}/delete/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/invoice/invoice_delete.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/invoice/invoice_delete.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('finance-invoice'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-invoice-add-order',
            array(
                'title' => 'Счета',
                'url' => '/admin/shop/finance/invoice/add/{id}/order/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/invoice/invoice_add_byorder.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/invoice/invoice_add_byorder.php',
                'moveto' => 'shop-finance-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('finance-invoice'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-invoice-block',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/invoice/invoice_block.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/invoice/invoice_block.php',
                'level' => '2',
                'role' => array('finance-invoice'),
            ),
            'override'
        );

        // Tabs
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-finance-tab-order',
            array(
                'title' => 'Payments of order',
                'url' => array(
                    '/admin/shop/orders/{id}/payment/',
                    '/admin/customorder/{type}/{id}/payment/'
                ),
                'filehtml' => dirname(__FILE__) . '/contents/admin/tab/orders_payment.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/tab/orders_payment.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        // Tabs
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-finance-tab-user',
            array(
                'title' => 'Payments of user',
                'url' => '/admin/shop/users/{id}/payment/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/tab/users_payment.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/tab/users_payment.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        // Blocks
        Engine::GetContentDataSource()->registerContent(
            'admin-finance-user-block',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/block/user_finance_block.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/block/user_finance_block.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-finance-probation-received-ajax',
            array(
                'url' => '/admin/shop/finance/probation/received/ajax/',
                'filephp' => dirname(__FILE__) . '/contents/admin/ajax/probation_received_ajax.php',
            ),
            'override'
        );

        // block
        Engine::GetContentDataSource()->registerContent(
            'finance-expected-percent-amount',
            array(
                'filehtml' => dirname(__FILE__) .
                    '/contents/admin/block-action/finance_expected_percent_amount.html',
                'filephp' => dirname(__FILE__) .
                    '/contents/admin/block-action/finance_expected_percent_amount.php',
            ),
            'override'
        );

    }

}