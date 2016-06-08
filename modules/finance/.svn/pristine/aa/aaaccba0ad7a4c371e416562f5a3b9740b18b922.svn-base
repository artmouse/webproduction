<?php
class tpl_finance extends Engine_Class {

    public function process() {
        $cuser = $this->getUser();

        $enableCountingFunds = !Engine::Get()->getConfigFieldSecure('finance-countingfunds-disable');

        if ($enableCountingFunds) {
            $currencyTotal = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $balanceTotal = 0;

            // список всех аккаунтов по контракторам
            $contractorArray = array();
            $contractors = Shop::Get()->getShopService()->getContractorsActive();
            while ($c = $contractors->getNext()) {
                $accounts = FinanceService::Get()->getAccountsActive();
                $accounts->setContractorid($c->getId());

                $accountsAllowed = false;

                $a = array();
                $balanceContractor = 0;
                while ($x = $accounts->getNext()) {
                    try {
                        if ($cuser->isDenied('finance-account-'.$x->getId().'-view')) {
                            continue;
                        }

                        $accountsAllowed = true;

                        $balance = $x->makeBalance();
                        if ($balance == 0) {
                            $balance = 0;
                        }

                        $a[] = array(
                        'name' => $x->makeName(),
                        'currency' => $x->getCurrency()->getName(),
                        'balance' => $balance,
                        'url' => $x->makeURL(),
                        );

                        $tmp = Shop::Get()->getCurrencyService()->convertCurrency(
                            $balance,
                            $x->getCurrency(),
                            $currencyTotal
                        );

                        // считаем баланс контрактора
                        $balanceContractor += $tmp;

                        // считаем общий баланс
                        $balanceTotal += $tmp;
                    } catch (Exception $e) {

                    }
                }

                if ($accountsAllowed) {
                    $contractorArray[] = array(
                        'name' => $c->getName(),
                        'accountArray' => $a,
                        'balance' => $balanceContractor,
                        'url' => Engine::GetLinkMaker()->makeURLByContentIDParam(
                            'shop-finance-index',
                            $c->getId(),
                            'contractorid'
                        )
                    );
                }
            }

            if (Engine::Get()->getConfigFieldSecure('project-box')) {
                // список фондов
                $categories = FinanceService::Get()->getCategoryAll();
                $categoryArray = array();
                while ($category = $categories->getNext()) {
                    if ($category->isFund()) {
                        $categoryArray[] = array(
                            'name' => $category->getName(),
                            'balance' => $category->getFundtotal(),
                            'url' => Engine::GetLinkMaker()->makeURLByContentIDParam(
                                'shop-finance-index',
                                $category->getId(),
                                'categoryid'
                            )
                        );
                    }
                }
                $this->setValue('categoryArray', $categoryArray);
            }

            $this->setValue('contractorArray', $contractorArray);
            $this->setValue('balanceTotal', $balanceTotal);
            $this->setValue('currencyTotal', $currencyTotal->getName());
        }

        $currencyAll = Shop::Get()->getCurrencyService()->getCurrencyAll();
        $currencyAll->setHidden(0);
        $currencyAll->setDefault(0);

        $currencyArray = array();
        while ($x = $currencyAll->getNext()) {
            $currencyArray[] = array(
                'name' => $x->getName(),
                'rate' => $x->getRate(),
            );
        }

        $this->setValue('currencyArray', $currencyArray);

        // ожидаемые платежи
        $probationArray = array();
        $probationTotal = 0;
        $probation = new XFinanceProbation();
        $probation->setOrder('pdate');
        $probation->addWhere('pdate', DateTime_Object::Now()->preview('Y-m-d'), '>=');
        while ($x = $probation->getNext()) {
            try {
                if (isset($probationArray[$x->getPdate()])) {
                    $probationPrice = Shop::Get()->getCurrencyService()->convertCurrency(
                        $x->getAmount(),
                        Shop::Get()->getCurrencyService()->getCurrencyByID($x->getCurrencyid()),
                        Shop::Get()->getCurrencyService()->getCurrencySystem()
                    );
                    $probationArray[$x->getPdate()] += $probationPrice;
                    $probationTotal += $probationPrice;
                } else {
                    $probationPrice = Shop::Get()->getCurrencyService()->convertCurrency(
                        $x->getAmount(),
                        Shop::Get()->getCurrencyService()->getCurrencyByID($x->getCurrencyid()),
                        Shop::Get()->getCurrencyService()->getCurrencySystem()
                    );
                    $probationArray[$x->getPdate()] = $probationPrice;
                    $probationTotal += $probationPrice;
                }
            } catch (Exception $e) {

            }
        }
        $this->setValue('probationArray', $probationArray);
        $this->setValue('probationTotal', $probationTotal);

        $this->setValue('allowSettings', $this->getUser()->getLevel() >= 3);

        // передаем все ACL user'a
        $acl = Shop::Get()->getUserService()->getUserACLArray(
            $cuser
        );

        $this->setValue('acl', $acl);
    }

}