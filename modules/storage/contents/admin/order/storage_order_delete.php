<?php
class storage_order_delete extends Engine_Class {

    public function process() {
        try {
            $order = StorageOrderService::Get()->getStorageOrderByID(
                $this->getArgument('id')
            );
            
            $cuser = $this->getUser();
            
            if (!$cuser->isAllowed('storage-'.$order->getType()) || 
            ($cuser->getId() != $order->getUserid() && !$cuser->isAllowed('storage-orders-edit'))) {
                throw new ServiceUtils_Exception();
            }

            $this->setValue('orderid', $order->getId());
            $this->setValue('ordertype', $order->getType());
            $this->setValue('isshipped', $order->getIsshipped());

            if ($this->getControlValue('ok')) {
                try {
                    StorageOrderService::Get()->deleteStorageOrder(
                        $order,
                        $cuser
                    );

                    $this->setValue('urlredirect', '/admin/shop/storage/orders/transfer/');
                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}