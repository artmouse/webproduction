<?php
class finance_payment_list extends Engine_Class {

    /**
     * Получить платежи
     *
     * @return FinancePayment
     */
    private function _getPayments() {
        return $this->getValue('payments');
    }

    public function process() {
        try {
            $cuser = $this->getUser();


            // валюты
            $currencyArray = array();
            $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
            $currency->setHidden(0);
            while ($x = $currency->getNext()) {
                $currencyArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
                );
            }

            $this->setValue('currencyArray', $currencyArray);

            $payments = $this->_getPayments();

            $a = array();
            while ($x = $payments->getNext()) {
                $accountArray = array();
                try {
                    $account = $x->getAccount();
                    $accountArray = array(
                        'url' => $account->makeURL(),
                        'name' => $account->getName(),
                    );

                } catch (Exception $e) {

                }

                $parentName = false;
                $parentUrl = false;
                $parentId = false;
                try {
                    $order = $x->getOrder();
                    $parentName = $order->makeName();
                    $parentUrl = $order->makeURLEdit();
                    $parentId = $order->getId();
                } catch (Exception $eorder) {

                }

                try {
                    $a[] = array(
                        'pdate' => DateTime_Formatter::DateTimeISO9075($x->getPdate()),
                        'cdate' => DateTime_Formatter::DateTimeISO9075($x->getCdate()),
                        'amount' => $x->getAmount(),
                        'currency' => $x->getCurrency()->getName(),
                        'id' => $x->getId(),
                        'noBalance' => $x->getNoBalance(),
                        'url' => Engine::GetLinkMaker()->makeURLByContentIDParam(
                            'shop-finance-payment-control', $x->getId(), 'key'
                        ),
                        'parentName' => $parentName,
                        'parentId' => $parentId,
                        'parentUrl' => $parentUrl,
                        'account' => $accountArray
                    );
                } catch (Exception $e) {

                }
            }

            $this->setValue('paymentArray', $a);
        } catch (Exception $e) {

        }
    }
}