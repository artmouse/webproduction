<?php
class users_payment extends Engine_Class {

    public function process() {
        try {
            $user = Shop::Get()->getUserService()->getUserByID(
                $this->getArgument('id')
            );

            if (!Shop::Get()->getUserService()->isUserViewAllowed($user, $this->getUser())) {
                throw new ServiceUtils_Exception('user');
            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-users-menu');
            $menu->setValue('selected', 'user-finance');
            $menu->setValue('userid', $user->getId());
            $this->setValue('menu', $menu->render());

            Engine::GetHTMLHead()->setTitle(
                'Финансы '.$user->makeName()
            );

            $payments = PaymentService::Get()->getPaymentsAll();
            $payments->setDeleted(0);
            $payments->setClientid($user->getId());
            $payments->setOrder('pdate', 'DESC');

            // фильтры
            $accountID = $this->getArgumentSecure('accountid');
            $contractorID = $this->getArgumentSecure('contractorid');
            $direction = $this->getArgumentSecure('direction');
            $dateFrom = $this->getControlValue('datefrom');
            $dateTo = $this->getControlValue('dateto');

            // фильтр по аккаунту
            if ($accountID) {
                $payments->setAccountid($accountID);
                // фильтр по юр лицу
            } elseif ($contractorID) {
                $accounts = FinanceService::Get()->getAccountsAll();
                $accounts->setContractorid($contractorID);

                $accountIDArray = array(-1);
                while ($x = $accounts->getNext()) {
                    $accountIDArray[] = $x->getId();
                }
                $payments->addWhereArray($accountIDArray, 'accountid');
            }

            if ($dateFrom) {
                $dateFrom = DateTime_Corrector::CorrectDateTime($dateFrom);
                $payments->addWhereQuery('( DATE(`pdate`) >= \''.$dateFrom.'\' )');
            }

            if ($dateTo) {
                $dateTo = DateTime_Corrector::CorrectDateTime($dateTo);
                $payments->addWhereQuery('( DATE(`pdate`) <= \''.$dateTo.'\' )');
            }

            if ($direction == 'in') {
                $payments->addWhere('amount', '0', '>');

            } elseif ($direction == 'out') {
                $payments->addWhere('amount', '0', '<');
            }

            // блок платежей
            $block_payments = Engine::Get()->GetContentDriver()->getContent('shop-finance-payment-list');
            $block_payments->setValue('payments', $payments);
            $this->setValue('block_payments', $block_payments->render());

            // юр лица
            $contractors = Shop::Get()->getShopService()->getContractorsActive();
            $contractorArray = array();
            $accountArray = array();

            $cuser = $this->getUser();

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

            $this->setValue('contractorArray', $contractorArray);
            $this->setValue('accountArray', $accountArray);


        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}