<?php

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

$transaction = new ShopStorageTransaction();
$transaction->setOrder('id', 'DESC');

$user = Shop::Get()->getUserService()->getUsersAll();
$user->setOrder('id');
$user->setLevel(3);
$user = $user->getNext();

while ($x = $transaction->getNext()) {
    print "update #".$x->getId();

    StorageService::Get()->updateStorageTransactionProduct(
        $user,
        $x
    );
}

print "\n\ndone.\n\n";