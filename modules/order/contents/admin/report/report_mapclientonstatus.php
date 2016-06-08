<?php
class report_mapclientonstatus extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('//api-maps.yandex.ru/2.0-stable/?load=package.full&lang=ru-RU');
        PackageLoader::Get()->registerJSFile('/_js/yandex.maps.api.js');
        $date = $this->getArgumentSecure('date');

        if (!$date) {
            $date = DateTime_Object::Now()->setFormat('Y-m-d')->__toString();
            $this->setControlValue('date', $date);
        }      

        $workflowIDArray = $this->getArgumentSecure('workflowid', 'array');
        $statusIDArray = $this->getArgumentSecure('statusid', 'array');       
        
        $managerID = $this->getArgumentSecure('managerid', 'int');
        
        $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
       
        
        if ($managerID) {
            $orders->setManagerid($managerID);
        }
        $orders->addWhere('cdate', $date.' 00:00:00', '>=');
        $orders->addWhere('cdate', $date.' 23:59:59', '<=');
        
        if ($workflowIDArray) {
            $orders->addWhereArray($workflowIDArray, 'categoryid');
        }
        if ($statusIDArray) {
            $orders->addWhereArray($statusIDArray, 'statusid');
        }
        while ($ord = $orders->getNext()) {
            try {
                if (!$ord->getClientaddress()) {
                    continue;
                }
                $clientsArray[] = $ord->getClientaddress();
            } catch (Exception $ex) {
                
            }           
        }
        $this->setValue('clientsArray', json_encode($clientsArray));

        // менеджеры
        $a = array();
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(true, 'lfm'),
            );
        }
        $this->setValue('managerArray', $a);
        
        // статусы заказов
        $block = Engine::GetContentDriver()->getContent('workflow-filter-block');
        $this->setValue('block_workflow_filter', $block->render());
    }

}