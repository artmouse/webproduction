<?php
class storage_order_add extends Engine_Class {

    public function process() {
        try {
            $type = $this->getArgument('type');
            $cuser = $this->getUser();
            
            if (!$cuser->isAllowed('storage-'.$type)) {
                throw new ServiceUtils_Exception();
            }
             
            if (!in_array($type, StorageOrderService::Get()->getOrderTypeArray())) {
                throw new ServiceUtils_Exception();
            }
            
            $order = StorageOrderService::Get()->makeStorageOrderEmpty($cuser, $type);

            $urlRedirect = $order->makeURLEdit();
            $this->setValue('urlredirect', $urlRedirect);
        } catch (Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}