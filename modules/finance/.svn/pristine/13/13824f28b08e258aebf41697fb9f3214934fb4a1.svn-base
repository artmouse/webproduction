<?php
class finance_account_add extends Engine_Class {

    public function process() {
        $cuser = $this->getUser();

        if ($this->getArgumentSecure('ok')) {
            try {
                SQLObject::TransactionStart();

                FinanceService::Get()->addAccount(
                $cuser,
                $this->getControlValue('name'),
                $this->getControlValue('description'),
                $this->getControlValue('currencyid'),
                $this->getControlValue('active'),
                $this->getControlValue('contractorid'),
                $this->getControlValue('balancestart')
                );

                SQLObject::TransactionCommit();

                $this->setValue('message', 'success');                
                $this->setValue('urlredirect', Engine::GetLinkMaker()->makeURLByContentID(
                'shop-finance-account'
                ));
            } catch (ServiceUtils_Exception $se) {
                SQLObject::TransactionRollback();

                $this->setValue('message', 'error');
                $this->setValue('errorArray', $se->getErrorsArray());
            }
        }
        
        // валюты
        $currencies = Shop::Get()->getCurrencyService()->getCurrencyActive();
        $this->setValue('currencyArray', $currencies->toArray());

        // юр лица
        $contractors = Shop::Get()->getShopService()->getContractorsActive();
        $this->setValue('contractorArray', $contractors->toArray());
    }

}