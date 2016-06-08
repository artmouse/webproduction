<?php
class invoice_view extends Engine_Class {

    public function process() {
        try {
            $invoice = InvoiceService::Get()->getInvoiceByID(
                $this->getArgument('id')
            );

            $cuser = $this->getUser();

            // передаем данные о счете
            $this->setValue('id', $invoice->getId());
            $this->setValue('name', $invoice->getName());
            $this->setValue('cdate', $invoice->getCdate());

            try {
                $this->setValue('contractor', $invoice->getContractor()->getName());
            } catch (ServiceUtils_Exception $sse) {

            }

            $this->setValue('username', $invoice->getUser()->getName());
            $this->setValue('sum', $invoice->getSum());
            $this->setValue('currency', $invoice->getCurrency()->getSymbol());
            $this->setValue('type', $invoice->getType());
            $this->setValue('date', DateTime_Corrector::CorrectDate($invoice->getDate()));

            try {
                $this->setValue('client', $invoice->getClient()->getName());
            } catch (ServiceUtils_Exception $se) {

            }

            // если это счет по заказу
            try {
                if (preg_match("/^order-(\d+)$/ius", $invoice->getLinkkey(), $r)) {
                    $order = Shop::Get()->getShopService()->getOrderByID($r[1]);
                    $this->setValue('orderid', $order->getId());
                    $this->setValue(
                        'orderURL',
                        Engine::GetLinkMaker()->makeURLByContentIDParam(
                            'shop-admin-orders-control',
                            $order->getId(),
                            'id'
                        )
                    );
                }
            } catch (ServiceUtils_Exception $se) {

            }

            // получаем список товаров в счете

            $invoiceProducts = InvoiceService::Get()->getInvoiceProductsByInvoice(
                $invoice
            );

            $productArray = array();
            while ($x = $invoiceProducts->getNext()) {
                try {
                    $product = $x->getProduct();

                    // товары
                    $productArray[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    'productid' => $x->getProductid(),
                    'count' => (float) $product->getCountWithDivisibility($x->getAmount()),
                    'price' => $x->getPrice(),
                    'currency' => $x->getCurrency()->getSymbol()
                    );
                } catch (Exception $e) {

                }
            }

            $this->setValue('productArray', $productArray);

            $payments = PaymentService::Get()->getPaymentsByInvoice($cuser, $invoice);
            if ($payments->getNext()) {
                // получаем таблицу платежей
                $table = new Shop_ContentTable(
                    new Datasource_FinancePayment(
                        false,
                        false,
                        false,
                        false,
                        false,
                        false,
                        false,
                        false,
                        $invoice->getId()
                    )
                );

                $table->removeField('clientid');

                $field = new Forms_ContentFieldControlLink('id', 'shop-finance-payment-control', 'key');
                $field->setName('#');
                $table->addField($field);

                $field = new Forms_ContentFieldControlLink('cdate', 'shop-finance-payment-control', 'key');
                $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sozdan'));
                $table->addField($field);

                $this->setValue('table', $table->render());
            }

            // ссылки на действия

            // добавление платежа
            $this->setValue(
                'urlPayment',
                Engine::Get()->GetLinkMaker()->makeURLByContentIDParam(
                    'shop-finance-payment-add',
                    $invoice->getId(),
                    'invoiceid'
                )
            );

            $this->setValue('canEdit', !$invoice->getLinkkey());

            $this->setValue(
                'urlEdit',
                Engine::Get()->GetLinkMaker()->makeURLByContentIDParam(
                    'shop-finance-invoice-edit',
                    $invoice->getId()
                )
            );

            $this->setValue(
                'urlDelete',
                Engine::Get()->GetLinkMaker()->makeURLByContentIDParam(
                    'shop-finance-invoice-delete',
                    $invoice->getId()
                )
            );

            if (Shop_ModuleLoader::Get()->isImported('document')) {
                // блок документов
                $block_documents = Engine::Get()->GetContentDriver()->getContent('shop-admin-document-list-block');
                $block_documents->setValue('linkkey', $invoice->getClassname().'-'.$invoice->getId());
                $this->setValue('block_documents', $block_documents->render());
            }

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}