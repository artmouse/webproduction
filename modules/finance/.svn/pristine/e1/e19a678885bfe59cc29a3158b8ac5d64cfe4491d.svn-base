<?php
class invoice_edit extends Engine_Class {

    public function process() {
        try {
            $invoice = InvoiceService::Get()->getInvoiceByID(
            $this->getArgument('id')
            );
            
            if ($invoice->getLinkkey()) {
                throw new ServiceUtils_Exception();
            }

            $this->setValue('id', $invoice->getId());

            $cuser = $this->getUser();

            if ($this->getControlValue('ok')) {
                try {
                    InvoiceService::Get()->editInvoice(
                    $invoice,
                    $cuser,
                    $this->getControlValue('client')    ,
                    $this->getControlValue('clientid'),
                    $this->getControlValue('contractorid'),
                    $this->getArgumentSecure('sum', 'float'),
                    $this->getControlValue('currencyid'),
                    $this->getControlValue('type'),
                    $this->getControlValue('date')
                    );

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());

                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
            }

            try {
                $this->setValue('client', $invoice->getClient()->makeName());    
            } catch (ServiceUtils_Exception $se) {
                
            }
            
            $this->setControlValue('name', $invoice->getName());
            $this->setControlValue('clientid', $invoice->getClientid());
            $this->setControlValue('contractorid', $invoice->getContractorid());
            $this->setControlValue('sum', $invoice->getSum());
            $this->setControlValue('currencyid', $invoice->getCurrencyid());
            $this->setControlValue('type', $invoice->getType());
            $this->setControlValue('date', $invoice->getDate());

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
            
            $this->setValue('urlPayment', Engine::Get()->GetLinkMaker()->makeURLByContentIDParam(
            'shop-finance-payment-add',
            $invoice->getId(),
            'invoiceid'
            ));

            $this->setValue('urlView', Engine::Get()->GetLinkMaker()->makeURLByContentIDParam(
            'shop-finance-invoice-view',
            $invoice->getId()
            ));

            $this->setValue('urlDelete', Engine::Get()->GetLinkMaker()->makeURLByContentIDParam(
            'shop-finance-invoice-delete',
            $invoice->getId()
            ));

        } catch (Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}