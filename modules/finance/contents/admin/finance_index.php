<?php
class finance_index extends Engine_Class {

    public function process() {
        // фильтры
        $accountID = $this->getArgumentSecure('accountid');
        $contractorID = $this->getArgumentSecure('contractorid');
        $categoryIDArray = $this->getArgumentSecure('categoryid', 'array');
        $comment = $this->getArgumentSecure('comment');
        $direction = $this->getArgumentSecure('direction');

        // client id
        $clientIDArray = array();
        $clientid = $this->getArgumentSecure('clientid');

        if ($clientid && is_string($clientid)) {
            $clientIDArray = explode(',', $this->getArgumentSecure('clientid'));
        }

        foreach ($clientIDArray as $clId) {
            try{
                $user = Shop::Get()->getUserService()->getUserByID($clId);
                if ($user->getTypesex() == 'company') {
                    $allUsers = Shop::Get()->getUserService()->getUsersAll();
                    $allUsers->setCompany($user->getCompany());
                    $allUsers->addWhereQuery('(`id` IN (SELECT `userid` FROM `shoporder`))');
                    while ($x = $allUsers->getNext()) {
                        $clientIDArray[] = $x->getId();
                    }
                }
            } catch (Exception $e) {

            }
        }
        array_unique($clientIDArray);

        // manager id
        $userIDArray = array();
        if ($this->getArgumentSecure('userid')) {
            $userIDArray = explode(',', $this->getArgumentSecure('userid'));
        }

        $cuser = $this->getUser();

        $datasource = new Datasource_FinancePayment(
            $accountID,
            $contractorID,
            $this->getControlValue('datetype'),
            $this->getControlValue('datefrom'),
            $this->getControlValue('dateto'),
            $clientIDArray,
            $userIDArray,
            $categoryIDArray,
            false, // invoiceID
            false, // linkkey
            $comment
        );

        $clone_datasorse = clone $datasource;

        // таблица
        $table = new Shop_ContentTable($datasource);

        $table->removeField('clientid');

        $field = new Forms_ContentFieldControlLink('id', 'shop-finance-payment-control', 'key');
        $field->setName('#');
        $table->addField($field);

        $field = new Forms_ContentFieldControlLink('cdate', 'shop-finance-payment-control', 'key');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sozdan'));
        $table->addField($field);

        if ($direction == 'in') {
            $datasource->getSQLObject()->addWhere('amount', '0', '>');

        } elseif ($direction == 'out') {
            $datasource->getSQLObject()->addWhere('amount', '0', '<');
        }

        $enableCountingFunds = !Engine::Get()->getConfigFieldSecure('finance-countingfunds-disable');

        if ($enableCountingFunds) {
            // вывод статистики
            $connection = ConnectionManager::Get()->getConnectionDatabase();
            $sql = "SELECT COUNT(`id`) FROM `financepayment`
            WHERE (" . $datasource->getSQLObject()->makeWhereString().") AND `noBalance` = 0";
            $q = $connection->query($sql);
            $r = $connection->fetch($q);
            $this->setValue('dataCount', array_shift($r));

            $sql = "SELECT SUM(`amountbase`) FROM `financepayment`
            WHERE (" . $datasource->getSQLObject()->makeWhereString().") AND `amountbase` > 0 AND `noBalance` = 0";
            $q = $connection->query($sql);
            $r = $connection->fetch($q);
            $inSum = array_shift($r);
            $this->setValue('inSum', number_format($inSum, 2));

            $sql = "SELECT SUM(`amountbase`) FROM `financepayment`
            WHERE (" . $datasource->getSQLObject()->makeWhereString().") AND `amountbase` < 0 AND `noBalance` = 0";
            $q = $connection->query($sql);
            $r = $connection->fetch($q);
            $outSum = array_shift($r);
            $this->setValue('outSum', number_format($outSum, 2));

            $this->setValue('Sum', number_format($inSum + $outSum, 2));
          
            $this->setValue('currency', Shop::Get()->getCurrencyService()->getCurrencySystem()->getSymbol());
        }

        $this->setValue('table', $table->render());

        // Выбранные из клиентов
        $clientArray = array();
        foreach ($clientIDArray as $clientID) {
            try {
                $client = Shop::Get()->getUserService()->getUserByID($clientID);

                $clientArray[] = array(
                'id' => $clientID,
                'text' =>  $client->getTypesex() == 'company' ? Shop::Get()->getTranslateService()->getTranslateSecure(
                    'translate_kompaniya_'
                ).$client->getCompany():$client->makeName()
                );
            } catch (ServiceUtils_Exception $pe) {

            }
        }
        $this->setValue('clientArray', $clientArray);

        // Выбранные из менеджеров
        $userArray = array();
        foreach ($userIDArray as $userID) {
            try {
                $user = Shop::Get()->getUserService()->getUserByID($userID);

                $userArray[] = array(
                'id' => $userID,
                'text' => $user->makeName()
                );
            } catch (ServiceUtils_Exception $pe) {

            }
        }
        $this->setValue('userArray', $userArray);

        // категории
        $categories = FinanceService::Get()->getCategoryAll();
        $a = array();
        while ($x = $categories->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->getName()
            );
        }
        $this->setValue('categoryArray', $a);

        // юр лица
        $contractors = Shop::Get()->getShopService()->getContractorsActive();
        $contractorArray = array();
        $accountArray = array();

        while ($c = $contractors->getNext()) {
            $accounts = FinanceService::Get()->getAccountsActive();
            $accounts->setContractorid($c->getId());

            $accountsAllowed = false;

            while ($x = $accounts->getNext()) {
                if ($cuser->isDenied('finance-account-'.$x->getId().'-view')) {
                    continue;
                }

                $accountArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'contractorid' => $x->getContractorid()
                );

                $accountsAllowed = true;
            }

            if ($accountsAllowed) {
                $contractorArray[] = array(
                'id' => $c->getId(),
                'name' => $c->getName(),
                );
            }
        }

        $sumContractors = array();
      
        if (!$contractorID && $enableCountingFunds) {
            try {
                $payment = $clone_datasorse->getSQLObject();
                $payment->filterNoBalance(0);
                if ($direction == 'in') {
                    $payment->filterAmount('0', '>');
                } elseif ($direction == 'out') {
                    $payment->filterAmount('0', '<');
                }
                $paymentidArray = array();
                while ($p = $payment->getNext()) {
                    $paymentidArray[] = array(
                        'contractorid' => $p->getAccount()->getContractorid(),
                        'sum' => $p->getAmountbase(),
                    );
                }

                foreach ($contractorArray as $cn) {
                    $sumcontractor = 0;
                    foreach ($paymentidArray as $p) {
                        if ($cn['id'] == $p['contractorid']) {
                            $sumcontractor += $p['sum'];
                        }
                    }
                    $sumContractors[] = array(
                        'id' => $cn['id'],
                        'sum' => $sumcontractor,
                    );
                }
            } catch (Exception $e) {

            }
        }
        
        $this->setValue('sumContractorsArray', $sumContractors);
        $this->setValue('contractorArray', $contractorArray);
        $this->setValue('accountArray', $accountArray);

        $this->setControlValue('accountid', $accountID);
        if ($accountID && !$contractorID) {
            try {
                $account = FinanceService::Get()->getAccountByID($accountID);
                $contractorID = $account->getContractorid();
            } catch (ServiceUtils_Exception $se) {

            }
        }
        $this->setControlValue('contractorid', $contractorID);

        // выбранные мульти-фильтры
        $this->setValue('categorySelectedArray', $categoryIDArray);
        $this->setValue('userSelectedArray', $userIDArray);
        $this->setValue('clientSelectedArray', $clientIDArray);
    }

}