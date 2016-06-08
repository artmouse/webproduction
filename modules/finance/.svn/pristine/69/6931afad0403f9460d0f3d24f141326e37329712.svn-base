<?php
class invoice_add_byorder extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
            $this->getArgument('id')
            );

            $cuser = $this->getUser();

            try {
                $invoice = InvoiceService::Get()->makeInvoiceByOrder(
                $order,
                $cuser
                );

                $this->setValue('message', 'ok');
                $this->setValue('urlredirect', Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-finance-invoice-view',
                $invoice->getId()
                ));
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $e->getErrorsArray());

                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

        } catch (Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}