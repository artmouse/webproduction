<?php
class invoice_add extends Engine_Class {

    public function process() {
        $cuser = $this->getUser();

        if ($this->getArgumentSecure('ok')) {
            try {
                SQLObject::TransactionStart();

                $invoice = InvoiceService::Get()->addInvoice(
                $cuser,
                $this->getControlValue('name'),
                $this->getControlValue('clientid'),
                $this->getControlValue('contractorid'),
                $this->getArgumentSecure('sum', 'float'),
                $this->getControlValue('currencyid'),
                $this->getControlValue('type'),
                $this->getControlValue('date')
                );

                SQLObject::TransactionCommit();

                $this->setValue('message', 'success');
                $this->setValue('urlredirect', Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-finance-invoice-view',
                $invoice->getId()
                ));
            } catch (ServiceUtils_Exception $se) {
                SQLObject::TransactionRollback();

                $this->setValue('message', 'error');
                $this->setValue('errorArray', $se->getErrorsArray());
            }
        }

        // клиенты
        $users = Shop::Get()->getUserService()->getUsersAll();
        $a = array();
        while ($x = $users->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName()
            );
        }
        $this->setValue('clientArray', $a);

        // валюты
        $currencies = Shop::Get()->getCurrencyService()->getCurrencyActive();
        $this->setValue('currencyArray', $currencies->toArray());

        // юр лица
        $contractors = Shop::Get()->getShopService()->getContractorsActive();
        $this->setValue('contractorArray', $contractors->toArray());

    }

}