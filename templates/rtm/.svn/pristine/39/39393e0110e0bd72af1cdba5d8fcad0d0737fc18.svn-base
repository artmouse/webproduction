<?php
/**
 * Синхронизация дефолтных значений в базу данных
 */
try {
    SQLObject::TransactionStart();

    // синхронизируем данные в таблице settings
    $sync = new SQLObjectSync_Data(new XShopSettings());
    $sync->addData(
        array(
            'key' => 'only-avail-product',
        ),
        array(
            'value' => '',
        ),
        array(
            'name' => 'Показывать только товары в наличии',
            'type' => 'boolean',
            'tabname' => 'Настройки магазина',
            'description' => 'Включение/отключение показа товаров не в наличии на каталоге.
            Нужно учесть что изменения на каталоге происходят не сразу после переключения из за кеша'
        )
    );

    $sync->sync();

    SQLObject::TransactionCommit();
} catch (Exception $ge) {
    SQLObject::TransactionRollback();
    throw $ge;
}