<?php
class invoice_block extends Engine_Class {

    public function process() {
        try {
            $linkkey = $this->getValue('linkkey');

            preg_match("/^(\w+)-(\d+)$/ius", $linkkey, $r);
            if (!isset($r[1]) || !isset($r[2])) {
                throw new ServiceUtils_Exception();
            }
            
            $user = $this->getUser();
            
            if ($user->isDenied('finance-invoice')) {
                throw new ServiceUtils_Exception();
            }

            $classname = $r[1];
            $id = $r[2];

            if ($classname == 'order') {
                $order = Shop::Get()->getShopService()->getOrderByID($id);
                
                $this->setValue('invoiceListURL', Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-finance-invoice-index',
                $linkkey,
                'linkkey'
                ));
                
                $this->setValue('invoiceAddURL', Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-finance-invoice-add-order',
                $order->getId()
                ));
            }

        } catch (Exception $ge) {
            exit();
        }
    }

}