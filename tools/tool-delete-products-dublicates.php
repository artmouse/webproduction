<?php
/**
 * @author Andrii A.
 * Date: 15.12.14
 * Time: 10:51
 */
@list($script, $action, $field, $condition) = $argv;

if (!$action) {
    print "Скрипт принимает 3 параметра (указываем через пробел) : \n \n
    1 - действие : \n
        show - показываем дубликаты (по умолчанию);  \n
        hide - отмечаем дублкаты скрытыми и удаленными;  \n
        delete - удаляем товар;  \n  \n
    2 - Поле, по которому ищем дубли: \n
        name - по имени (по умолчанию); \n
        code1c - по коду 1С; \n  \n
    3 - Определение дублей: \n
        pricel - дублями считаем товары с меньшей ценой (по умолчанию);\n
        priceb - дублями считаем товары с большей ценой; \n  \n  \n
    ";
    exit;
}

if ($action != 'delete' && $action != 'hide') {
    $action = 'show';
}

if ($field != 'code1c') {
    $field = 'name';
}

$showCondition = 'pricel';

if ($condition == 'priceb') {
    $condition = 'ASC';
    $showCondition = 'priceb';
} else {
    $condition = 'DESC';
}



print "Идет процесс поиска дублей товаров c параметрами: \n
1 - {$action} \n
3 - {$field} \n
3 - {$showCondition} \n \n ";


set_time_limit(0);
include dirname(__FILE__)."/../packages/Engine/include.2.6.php";

$products = Shop::Get()->getShopService()->getProductsAll();

$products->setOrder('price', $condition);

$products->setDeleted(0);


$deletedArray = array();
$i = 0;
while ($baseProduct = $products->getNext()) {
    $i++;
    if ( $i%100 == 0) {
        print "{$baseProduct->getId()}\n ";
    }

    if (in_array($baseProduct->getId(), $deletedArray)) {
        continue;
    }
    try {
        $p = new ShopProduct();
        $p->addWhere('id', $baseProduct->getId(), '<>');
        $p->setDeleted(0);
        $p->setField($field, $baseProduct->getField($field));

        while ($dublicate = $p->getNext()) {
                $deletedArray[] = $dublicate->getId();
        }

    } catch (Exception $e) {

    }
}

if ($action == 'delete') {
    foreach($deletedArray as $id) {
        try {
            $product = new ShopProduct($id);
            Shop::Get()->getShopService()->deleteProduct($product);
            print "delete #{$product->getId()}; code1c - {$product->getCode1c()}; name - {$product->getName()}; price - {$product->getPrice()} \n ";
        } catch (Exception $e) {

        }
    }
} else if ($action == 'hide'){
    foreach($deletedArray as $id) {
        try {
            $product = new ShopProduct($id);
            $product->setHidden(1);
            $product->setDeleted(1);
            $product->update();
            print "hide #{$product->getId()}; code1c - {$product->getCode1c()}; name - {$product->getName()}; price - {$product->getPrice()} \n ";
        } catch (Exception $e) {

        }
    }
} else {
    foreach($deletedArray as $id) {
        try {
            $product = new ShopProduct($id);
            print "#{$product->getId()}; code1c - {$product->getCode1c()}; name - {$product->getName()}; price - {$product->getPrice()} \n ";
        } catch (Exception $e) {

        }
    }
}


print "\nDONE\n";