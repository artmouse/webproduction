<?php
class invoice_delete extends Engine_Class {

    public function process() {
        try {
            $invoice = InvoiceService::Get()->getInvoiceByID(
            $this->getArgument('id')
            );
            
            $this->setValue('id', $invoice->getId());
            
            $cuser = $this->getUser();

            if ($this->getControlValue('ok')) {
                try {
                    InvoiceService::Get()->deleteInvoice(
                    $invoice,
                    $cuser
                    );

                    $this->setValue('message', 'ok');
                    $this->setValue('urlredirect', Engine::GetLinkMaker()->makeURLByContentID('shop-finance-invoice-index'));
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());

                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
            }
            
            $this->setValue('urlPayment', Engine::Get()->GetLinkMaker()->makeURLByContentIDParam(
            'shop-finance-payment-add',
            $invoice->getId(),
            'invoiceid'
            ));

            $this->setValue('urlView', Engine::Get()->GetLinkMaker()->makeURLByContentIDParam(
            'shop-finance-invoice-view',
            $invoice->getId()
            ));
            
            $this->setValue('urlEdit', Engine::Get()->GetLinkMaker()->makeURLByContentIDParam(
            'shop-finance-invoice-edit',
            $invoice->getId()
            ));

        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}