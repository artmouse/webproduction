<?php

class ShopBuildProductCategory_CronMinute implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        // смотрим есть ли задача на перестройку
        // смотрим последнюю запись - если она не закрыта (pdate), то нужно делать пересчёт
        $productBuildTask = new XShopBuildProductCategoryTask();
        $productBuildTask->setOrder('id', 'DESC');
        $productBuildTask = $productBuildTask->getNext();
        if (!$productBuildTask) {
            return;
        }
        if ($productBuildTask->getPdate() != '0000-00-00 00:00:00') {
            return;
        }


        // Сделано по дыбильному. Другого метода пока не нашел.
        // @TODO переделать по нормальному.
        // 1 SQL-запросом перестроить дерево категорий у всех товаров в этой категории.

        // Обновляем дерево категорий у товаров.
        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setOrderBy('categoryid'); // оптимизация кеша по категориям

        $transactions = 250;
        $index = 0;

        SQLObject::TransactionStart();

        while ($product = $products->getNext()) {

            // устанавливаем родительские категории
            try {
                Shop::Get()->getShopService()->buildProductCategories($product);
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            $index++;
            if ($index % $transactions == 0) {
                SQLObject::TransactionCommit();
                SQLObject::TransactionStart();
            }
        }

        SQLObject::TransactionCommit();

        $now = DateTime_Object::Now();
        $productBuildTask->setPdate($now);
        $productBuildTask->update();

        // закрываем все задачи, которые были открыты до этого момента (теоретически их может быть несколько)
        $id = $productBuildTask->getId();

        $connection = ConnectionManager::Get()->getConnectionDatabase();
        $query = 'UPDATE shopbuildproductcategorytask SET `pdate` = "' . $now . '" WHERE `id` < ' . $id;
        $query .= ' AND `pdate` = "0000-00-00 00:00:00"';
        $connection->query($query);

        echo "buid product category end\n";
    }
}