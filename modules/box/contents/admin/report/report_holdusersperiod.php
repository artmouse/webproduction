<?php
class report_holdusersperiod extends Engine_Class {

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
       
        $events = new ShopEvent();
        
        if ($dateFrom) {
            $events->addWhere('cdate', $dateFrom, '>=');
        }
        if ($dateTo) {
            $events->addWhere('cdate', $dateTo.' 23:59:59', '<=');
        }   

        // условия фильтрации
        $from = $this->getControlValue('from');
        if ($from) {
            $events->addWhere('from', '%'.$from.'%', 'LIKE');
        }

        $to = $this->getControlValue('to');
        if ($to) {
            $events->addWhere('to', '%'.$to.'%', 'LIKE');
        }

        $type = $this->getControlValue('type');
        if ($type) {
            $events->setType($type);
        }

        $status = $this->getControlValue('status');
        if ($status) {
            $events->setStatus(strtoupper($status));
        }

        if ($type == 'email') {
            $events->setStatus('');
        }
 
        $arrayUserId = array();
        
        while ($x = $events->getNext()) {
            
            if ($x->getTouserid()) {
                $arrayUserId[] = $x->getTouserid();
            }
            if ($x->getFromuserid()) {
                $arrayUserId[] = $x->getFromuserid();
            }        
        }        
        
        $workflowIDArray = $this->getArgumentSecure('workflowid', 'array');
        $statusIDArray = $this->getArgumentSecure('statusid', 'array');
        
        $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
        if ($workflowIDArray) {
            $orders->addWhereArray($workflowIDArray, 'categoryid');
        }
        if ($statusIDArray) {
            $orders->addWhereArray($statusIDArray, 'statusid');
        }       
        if ($dateFrom) {
            $orders->addWhere('cdate', $dateFrom, '>=');
        }
        if ($dateTo) {
            $orders->addWhere('cdate', $dateTo.' 23:59:59', '<=');
        }
        
        while ($o = $orders->getNext()) {
            try {
                $arrayUserId[] = $o->getClient()->getId();
            } catch (Exception $e) {
                
            }           
        }
        $arrayUserId = array_unique($arrayUserId);
        $clients = Shop::Get()->getUserService()->getUsersAll();
        if ($this->getArgumentSecure('not-active')) {
            $clients->addWhereArray($arrayUserId, 'id', '!=');
        } else {
            $clients->addWhereArray($arrayUserId, 'id', '=');
        }
        $clients->addWhere('level', 1, '<=');
        
        $clientsArray = array();
        while ($u = $clients->getNext()) { 
            $a['id'] = $u->getId();
            $a['url'] = $u->makeURLEdit();
            $a['name'] = $u->makeName();
            $a['company'] = $u->getCompany();
            $a['phone'] = $u->getPhone();
            $a['email'] = $u->getEmail();
            $a['address'] = $u->getAddress();
            
            $company = Shop::Get()->getUserService()->getUsersAll();
            $company->setTypesex('company');
            $company->setCompany($u->getCompany());          
            $co = $company->getNext();
            if ($co) {
                $a['phoneCompany'] = $co->getPhone();       
                $a['emailCompany'] = $co->getEmail();       
                $a['addressCompany'] = $co->getAddress(); 
            }
            $clientsArray[] = $a;
        }
        $this->setValue('clientsArray', $clientsArray);
        // статусы заказов
        $block = Engine::GetContentDriver()->getContent('workflow-filter-block');
        $this->setValue('block_workflow_filter', $block->render());

        $this->setValue('urlget', Engine::GetURLParser()->getGETString());
        
        if ($this->getArgumentSecure('export-xls')) {
            $data = false;
            foreach ($clientsArray as $item => $prod) {
                $x = array();
                $x['id'] = $prod['id'];
                $x['Контакт'] = $prod['name'];
                $x['Компания'] = $prod['company'];
                $x['Телефон клиента'] = $prod['phone'];
                $x['Телефон компании'] = $prod['phoneCompany'];
                $x['E-mail клиента'] = $prod['email'];
                $x['E-mail компании'] = $prod['emailCompany'];
                $x['Адресс клиента'] = $prod['address'];
                $x['Адресс компании'] = $prod['addressCompany'];
                $data[] = $x;
            }
            $filename = 'export '.date('Y-m-d H:i:s').' holdusersperiod';
            PackageLoader::Get()->import('XLS');
            $xls = XLS_Creator::CreateFromArray($data);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="'.$filename.'.xls"');
            print $xls->__toString();
            exit();
        }
    }
}