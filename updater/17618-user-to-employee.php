<?php
// всем пользователям, у которых level>=2 проставить employer=1
$users = Shop::Get()->getUserService()->getUsersAll();
$users->setEmployer(0);
$users->addWhere('level', '1', '>');
while ($x = $users->getNext()) {
    print "set employer #".$x->getId()."\n";

    $x->setEmployer(1);
    $x->update();
}