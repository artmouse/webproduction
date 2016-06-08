<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

PackageLoader::Get()->import('CommentsAPI');

$orders = Shop::Get()->getShopService()->getOrdersAll();
$orders->addWhere('comments', '', '!=');
while ($x = $orders->getNext()) {
    $comment = $x->getComments();
    $comment = trim($comment);

    if (!$comment) {
        continue;
    }

    print $x->getId()."\n";

    $userID = $x->getAuthorid();
    if (!$userID) {
        $userID = $x->getManagerid();
    }

    $tmp = CommentsAPI::Get()->addComment(
    'shop-order-'.$x->getId(),
    $comment,
    $userID
    );

    $tmp->setCdate($x->getCdate());
    $tmp->update();
}

print "\n\ndone.\n\n";