<?php
class finance_account_control extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $account = FinanceService::Get()->getAccountByID(
            $this->getArgument('key')
            );

            $this->setValue('id', $account->getId());

            if ($this->getArgumentSecure('delete')) {
                try {
                    // удаление
                    FinanceService::Get()->deleteAccount($account, $cuser);

                    $this->setValue('message', 'deleted');
                    $this->setValue('urlredirect', Engine::GetLinkMaker()->makeURLByContentID(
                    'shop-finance-account'
                    ));
                } catch (ServiceUtils_Exception $de) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorArray', $de->getErrorsArray());
                }
            }

            if ($this->getArgumentSecure('ok')) {
                try {
                    SQLObject::TransactionStart();

                    FinanceService::Get()->editAccount(
                    $account,
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
                } catch (ServiceUtils_Exception $se) {
                    SQLObject::TransactionRollback();

                    $this->setValue('message', 'error');
                    $this->setValue('errorArray', $se->getErrorsArray());
                }
            }

            $this->setControlValue('name', $account->getName());
            $this->setControlValue('description', $account->getDescription());
            $this->setControlValue('currencyid', $account->getCurrencyid());
            $this->setControlValue('active', $account->getActive());
            $this->setControlValue('contractorid', $account->getContractorid());
            $this->setControlValue('balancestart', $account->getBalancestart());

            // валюты
            $currencies = Shop::Get()->getCurrencyService()->getCurrencyActive();
            $this->setValue('currencyArray', $currencies->toArray());

            // юр лица
            $contractors = Shop::Get()->getShopService()->getContractorsActive();
            $this->setValue('contractorArray', $contractors->toArray());
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}