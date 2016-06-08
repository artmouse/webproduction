<?php
require_once(dirname(__FILE__) . '/../packages/Engine/include.2.6.php');

$workflowsType = unserialize(Shop::Get()->getSettingsService()->getSettingValue('calendar-show-type'));

foreach ($workflowsType as $type) {
    $typeObj = new XShopWorkflowType();
    $typeObj->setType($type);
    while ($x = $typeObj->getNext()) {
        $x->setCalendarShow(1);
        $x->update();
    }
}

$settings = new XShopSettings();
$settings->setKey('calendar-show-type');
while ($x = $settings->getNext()) {
    $x->delete();
}

print "\n\ndone\n\n";