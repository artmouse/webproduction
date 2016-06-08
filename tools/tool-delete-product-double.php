<?php

require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');
$delete = false;
if (@$argv[1] == 'delete') {
    $delete = true;
}

// Соединение с БД
$connection = ConnectionManager::Get()->getConnectionDatabase();

$sql = "
    SELECT COUNT(name) AS repetitions, name
    FROM shopproduct
    GROUP BY name
    HAVING repetitions > 1;
";

$q = $connection->query($sql);
$productsName = array();
while ($p = $connection->fetch($q)) {
    $productsName[] = $p['name'];
}

$resultArray = array();
foreach ($productsName as $name) {
    $products = new XShopProduct();
    $products->setName($name);
    $products->setOrder('id');
    $count = 0;
    $str = "";
    while ($x = $products->getNext()) {
        $count++;
        if ($delete) {
            // товар с наименьшем id пропускаем, это будет первый товар
            if ($count > 1) {
                print "delete ".$x->getId()."\n";
                $x->delete();
            }
        } else {

            $str .= $x->getId().",";
        }

    }

    if (!$delete) {
        print $name." counts - ".$count." ids - ".$str."\n";
    }

}

print "\n\ndone\n\n";