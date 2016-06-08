<?php

require_once(dirname(__FILE__) . '/../packages/Engine/include.2.6.php');

$workflows = Shop::Get()->getShopService()->getWorkflowsAll();
$workflows->setType('issue');
while ($x = $workflows->getNext()) {
    $tabMenuWorkflow = new XShopWorkflowMenu();
    $tabMenuWorkflow->setWorkflowid($x->getId());
    $tabMenuWorkflow->setName('parent');
    if (!$tabMenuWorkflow->getCount()) {
        $tabMenuWorkflow->insert();
    }
}

$workflows = Shop::Get()->getShopService()->getWorkflowsAll();
$workflows->setType('order');
while ($x = $workflows->getNext()) {
    $x->setShowOrderMenu(1);
    $x->update();
}

print "\n\ndone\n\n";