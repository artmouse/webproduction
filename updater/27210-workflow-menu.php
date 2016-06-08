<?php
require_once(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$menu = new XShopWorkflowMenu();
$menu->delete(true);

$workflows = Shop::Get()->getShopService()->getWorkflowsAll();
while ($w = $workflows->getNext()) {
    // Задачи
    $menu = new XShopWorkflowMenu();
    $menu->setWorkflowid($w->getId());
    $menu->setName('issue');
    $menu->insert();

    // Заказы
    $menu = new XShopWorkflowMenu();
    $menu->setWorkflowid($w->getId());
    $menu->setName('order');
    $menu->insert();

    // Информация
    $menu = new XShopWorkflowMenu();
    $menu->setWorkflowid($w->getId());
    $menu->setName('info');
    $menu->insert();

    // Продукты
    $menu = new XShopWorkflowMenu();
    $menu->setWorkflowid($w->getId());
    $menu->setName('products');
    $menu->insert();

    // дополнительные табы от модулей
    $user = Shop::Get()->getUserService()->getUsersAll();
    $user->setLevel(3);
    $user = $user->getNext();

    $moduleTabArray = Shop_ModuleLoader::Get()->getOrderTabArray($user);
    foreach ($moduleTabArray as $key=>$item) {
        // Продукты
        $menu = new XShopWorkflowMenu();
        $menu->setWorkflowid($w->getId());
        $menu->setName($item['contentID']);
        $menu->insert();
    }
}
print "\n\ndone\n\n";