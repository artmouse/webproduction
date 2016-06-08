<?php
class storage_order_index extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();
            $ordertype = $this->getArgument('type');

            if (!in_array($ordertype, StorageOrderService::Get()->getOrderTypeArray())) {
                throw new ServiceUtils_Exception();
            }

            $table = new Shop_ContentTable(new Datasource_StorageOrder($cuser, $ordertype));
            $this->setValue('table', $table->render());
            
            $this->setValue('ordertype', $ordertype);
        } catch (ServiceUtils_Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}