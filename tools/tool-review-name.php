<?php
/*
 * Проходимся по всем отзывам о товарах/магазине
 * И прописываем поля username
 */
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

// комментарии к товарам
$productComments = Shop::Get()->getShopService()->getProductCommentsAll();
$productComments->addWhere('username','','=');
while ($x = $productComments->getNext()) {

    try{
        $user = Shop::Get()->getUserService()->getUserByID($x->getUserid());
        $name = $user->getName();
        if (!$name) {
            $name = $user->getLogin();
        }
        $x->setUsername($name);
        $x->update();
        print "\n update productComments ".$x->getId();
    } catch (Exception $e) {
        print "\n not find user, productComments ".$x->getId();
    }
}

// комментарии магазина
$shopComments = Shop::Get()->getGuestBookService()->getGuestBookAll();
$shopComments->addWhere('name','','=');
while ($x = $shopComments->getNext()) {

    try{
        $user = Shop::Get()->getUserService()->getUserByID($x->getUserid());
        $name = $user->getName();
        if (!$name) {
            $name = $user->getLogin();
        }
        $x->setName($name);
        $x->update();
        print "\n update shopComments ".$x->getId();

    } catch (Exception $e) {
        print "\n not find user, shopComments ".$x->getId();
    }
}
print "\n\ndone.\n\n";