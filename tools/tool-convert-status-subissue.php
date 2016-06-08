<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$subData = new XShopOrderStatusActionBlockStructure();
$subData->setContentid('box-order-status-action-block-sub-workflow');
while ($x = $subData->getNext()) {
    $data = (Array) json_decode($x->getData());
    foreach ($data as $subWorkflow) {
        $id = $subWorkflow->id;
        $name = $subWorkflow->name;
        $date = $subWorkflow->date;
        $description = $subWorkflow->description;

        // количество заполненых строк
        if ($id || $name || $date || $description) {
            WorkflowStatusLoader::Get()->addBlockData(
                Shop::Get()->getShopService()->getStatusByID($x->getStatusid()),
                'box-order-status-action-block-sub-workflow2',
                $x->getSort(),
                json_encode(
                    array(
                    'id' => $id,
                    'name' => $name,
                    'date' => $date,
                    'description' => $description
                    )
                )
            );
        }
    }
}