<?php
require_once(dirname(__FILE__) . '/../packages/Engine/include.2.6.php');

$users = new User();
$users->setDeleted(0);
$users->setLevel(2);
$users->setOrder('id', 'DESC');
while ($x = $users->getNext()) {

    $acl = new XUserACL();
    $acl->setUserid($x->getId());
    $acl->setAcl('notification');
    if (!$acl->select()) {
        print "\nACL notification user #".$x->getId();
        $acl->insert();
    }
}

print "\n\ndone\n\n";