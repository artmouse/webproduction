<?php
class orders_index extends Engine_Class {

    public function process() {

        if ($this->getControlValue('change')) {
            try {
                SQLObject::TransactionStart();

                $orderStatus = $this->getControlValue('status');
                $contractorID = $this->getControlValue('contractor');
                $managerID = $this->getControlValue('manager');
                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $orderID) {
                        $order = Shop::Get()->getShopService()->getOrderByID($orderID);
                        if($orderStatus != '-1'){
                            Shop::Get()->getShopService()->updateOrderStatus($order, $orderStatus);
                        }
                        if($contractorID != '-1') {
                            $order->setContractorid($contractorID);
                        }
                        if($managerID != '-1') {
                            $order->setManagerid($managerID);
                        }
                        $order->update();
                    }
                }

                SQLObject::TransactionCommit();
            } catch (Exceprion $e) {
                SQLObject::TransactionRollback();
            }
        }

        if ($this->getControlValue('changeEdate')) {
            try {
                SQLObject::TransactionStart();

                $edate = $this->getControlValue('edate');
                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $orderID) {
                        $order = Shop::Get()->getShopService()->getOrderByID($orderID);
                        if($edate){
                            $order->setDateto($edate);
                            $order->update();
                        }
                    }
                }

                SQLObject::TransactionCommit();
            } catch (Exceprion $e) {
                SQLObject::TransactionRollback();
            }
        }

        if($this->getControlValue('delete')){
            try {
                SQLObject::TransactionStart();

                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $orderID) {
                        $order = Shop::Get()->getShopService()->getOrderByID($orderID);
                        $order->delete();
                    }
                }

                SQLObject::TransactionCommit();
            } catch (Exceprion $e) {
                SQLObject::TransactionRollback();
            }
        }


        $datasource = new Datasource_Orders_Kazakh();

        // поиск по серийному номеру
        $filterProductSerial = $this->getControlValue('productserial');
        if ($filterProductSerial) {
            $filterProductSerial = ConnectionManager::Get()->getConnectionDatabase()->escapeString($filterProductSerial);
            $query = "id IN (SELECT orderid FROM shoporderproduct WHERE serial LIKE '%".$filterProductSerial."%')";
            $datasource->getSQLObject()->addWhereQuery($query);
        }

        // поиск по названию товара
        $filterProductName = $this->getControlValue('productname');
        if ($filterProductName) {
            $filterProductName = ConnectionManager::Get()->getConnectionDatabase()->escapeString($filterProductName);
            $query = "id IN (SELECT orderid FROM shoporderproduct WHERE productname LIKE '%".$filterProductName."%')";
            $datasource->getSQLObject()->addWhereQuery($query);
        }

        // поиск по номеру товара
        $filterProductID = $this->getControlValue('productid');
        if ($filterProductID) {
            $filterProductID = ConnectionManager::Get()->getConnectionDatabase()->escapeString($filterProductID);
            $query = "id IN (SELECT orderid FROM shoporderproduct WHERE productid LIKE '%".$filterProductID."%')";
            $datasource->getSQLObject()->addWhereQuery($query);
        }

        $table = new Shop_ContentTable($datasource);
        $table->setRow(new Shop_ContentTableRowOrders());

        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-orders-control', 'id');
        $field->setName('#');
        $table->addField($field);

        $this->setValue('table', $table->render());

        $managers = $this->_getManagers();
        $this->setValue('managers', $managers);

        $contractors = Shop::Get()->getShopService()->getContractorsAll();
        $this->setValue('contractorsArray', $contractors->toArray());

        $status = $this->_getOrderStatus();
        $this->setValue('status', $status);

        $contractor = $this->_getContractors();
        $this->setValue('contractors', $contractor);

        $categories = Shop::Get()->getShopService()->getOrderCategoryAll();
        $categoryArray = array();
        while($x = $categories->getNext()){
            $categoryArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
            );
        }
        $this->setValue('categoryArray', $categoryArray);

        // источники
        $sources = Shop::Get()->getShopService()->getSourceAll();
        $this->setValue('sourceArray', $sources->toArray());

        // валюты
        $currencies = Shop::Get()->getCurrencyService()->getCurrencyActive();
        $a = array();
        while ($x = $currencies->getNext()) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'rate' => $x->getRate(),
            );
        }
        $this->setValue('orderCurrencyArray', $a);
    }

    private function _getOrderStatus(){
        $orderStatus = Shop::Get()->getShopService()->getStatusAll();
        $status = array();
        while ($x = $orderStatus->getNext()) {
            $status[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
            );
        }
        return $status;
    }

    private function _getContractors(){
        $contractor = Shop::Get()->getShopService()->getContractorsActive();
        $orderContractor = array();
        while ($x = $contractor->getNext()) {
            $orderContractor[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
            );
        }
        return $orderContractor;
    }

    private function _getManagers() {
        $users = Shop::Get()->getUserService()->getUsersManagers();
        $managers = array();
        while($x = $users->getNext()){
            $managers[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
            );
        }
        return $managers;
    }

}