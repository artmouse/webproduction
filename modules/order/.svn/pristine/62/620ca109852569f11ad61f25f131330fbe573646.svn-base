<?php
class report_clientonproduct extends Engine_Class {

    public function process() {
        $dateFrom = $this->getArgumentSecure('datefrom');
        $dateTo = $this->getArgumentSecure('dateto');

        if (!$dateFrom) {
            $dateFrom = DateTime_Object::Now()->addDay(+0)->setFormat('Y-m-01')->__toString();

            $this->setControlValue('datefrom', $dateFrom);
        } else {
            $dateFrom = DateTime_Object::FromString($dateFrom)->setFormat('Y-m-d')->__toString();
        }
        if (!$dateTo) {
            $dateTo = DateTime_Object::Now()->addMonth(+1)->setFormat('Y-m-t')->__toString();

            $this->setControlValue('dateto', $dateTo);
        } else {
            $dateTo = DateTime_Object::FromString($dateTo)->setFormat('Y-m-d')->__toString();
        }
 
        $workflowIDArray = $this->getArgumentSecure('workflowid', 'array');
        $statusIDArray = $this->getArgumentSecure('statusid', 'array');
        
        $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
        
        // поиск по названию товара
        $filterProductName = $this->getControlValue('filterproductname');
        if ($filterProductName) {
            $filterProductName = ConnectionManager::Get()->getConnectionDatabase()->escapeString(
                $filterProductName
            );           
            $query = "id IN (SELECT orderid FROM shoporderproduct
            WHERE productname LIKE '%".str_replace(' ', '%', $filterProductName)."%')";
            $orders->addWhereQuery($query);
        }       
        
        $orders->addWhere('cdate', $dateFrom, '>=');
        $orders->addWhere('cdate', $dateTo.' 23:59:59', '<=');
        
        if ($workflowIDArray) {
            $orders->addWhereArray($workflowIDArray, 'categoryid');
        }
        if ($statusIDArray) {
            $orders->addWhereArray($statusIDArray, 'statusid');
        }

        $clientsArray = array();
       
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
        $this->setValue('currency', $currencyDefault->getName());
        
        if ($filterProductName) {
            while ($order = $orders->getNext()) {
                try {
                    $clientsArray[] = array(
                        'idorder' => $order->getId(),
                        'name' => $order->getClient()->makeName(),
                        'email' => $order->getClientemail(),
                        'phone' => $order->getClientphone(),
                        'clientid' => $order->getClient()->getId()
                    );
                } catch (Exception $ex) {
                    
                }
            }
        }
        
        $this->setValue('clientsArray', $clientsArray);
        // статусы заказов
        $block = Engine::GetContentDriver()->getContent('workflow-filter-block');
        $this->setValue('block_workflow_filter', $block->render());
        $this->setValue('urlget', Engine::GetURLParser()->getGETString());
        if ($this->getArgumentSecure('export-xls')) {
            $data = false;
                       
            foreach ($clientsArray as $item => $val) {
                $x = array();
                $x['idorder'] = $val['idorder'];
                $x['name'] = $val['name'];
                $x['email'] = $val['email'];
                $x['phone'] = $val['phone'];   
                $data[] = $x;
            }
            $filename = 'export '.date('Y-m-d H:i:s').' clientonproduct';
            PackageLoader::Get()->import('XLS');
            $xls = XLS_Creator::CreateFromArray($data);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="'.$filename.'.xls"');
            print $xls->__toString();
            exit();
        }
    }  

}