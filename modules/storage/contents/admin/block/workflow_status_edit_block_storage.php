<?php
class workflow_status_edit_block_storage extends Engine_Class {

    public function process() {
        try {
            $status = $this->_getStatus();

            if ($this->getArgumentSecure('send_edit') && !Engine::GetURLParser()->getArgumentSecure('error')) {
                try {
                    $status->setStorage_incoming($this->getControlValue('storage_incoming'));
                    $status->setStoragenameid_incoming($this->getControlValue('storagenameid_incoming'));
                    $status->setStorage_sale($this->getControlValue('storage_sale'));
                    $status->setStorage_reserve($this->getControlValue('storage_reserve'));
                    $status->setStorage_unreserve($this->getControlValue('storage_unreserve'));
                    $status->setStorage_return($this->getControlValue('storage_return'));
                    $status->update();
                } catch (ServiceUtils_Exception $e) {

                }
            }

            $this->setValue('issue', ($status->getCategory()->getType() == 'issue'));

            $this->setControlValue('storagenameid_incoming', $status->getStoragenameid_incoming());
            $this->setControlValue('storage_incoming', $status->getStorage_incoming());
            $this->setControlValue('storage_sale', $status->getStorage_sale());
            $this->setControlValue('storage_reserve', $status->getStorage_reserve());
            $this->setControlValue('storage_unreserve', $status->getStorage_unreserve());
            $this->setControlValue('storage_return', $status->getStorage_return());

            $storageNamesIncoming = StorageNameService::Get()->getStorageNamesForTransfers();
            $storageNameIncomingArray = array();
            while ($storageNameIncoming = $storageNamesIncoming->getNext()) {
                $storageNameIncomingArray[] = array(
                    'id' => $storageNameIncoming->getId(),
                    'name' => $storageNameIncoming->getName()
                );
            }
            $this->setValue('storageNameIncomingArray', $storageNameIncomingArray);

            $storageName = StorageNameService::Get()->getStorageNamesForSale()->getNext();
            if ($storageName) {
                $this->setValue('storageName', $storageName->getName());
            }
        } catch (Exception $e) {

        }
    }

    /**
     * Получить статус
     *
     * @return ShopOrderStatus
     */
    private function _getStatus() {
        return $this->getValue('status');
    }

}