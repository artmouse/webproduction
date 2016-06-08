<?php
class block_kazakh_order extends Engine_Class {

    public function process() {
        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setOrder('sort');
        $products->setHidden(0);
        $a = array();
        $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();
        while ($p = $products->getNext()) {
            $a[] = array(
                'id' => $p->getId(),
                'name' => $p->getName(),
                'price' => $p->makePriceWithTax($currency),
                'currency' => $currency->getName()
            );
        }
        $this->setValue('productsArray',$a);

        if ($this->getArgumentSecure('kazakh_order')) {
            try {
                SQLObject::TransactionStart();

                if ($this->getControlValue('ajs') != 'ready') {
                    throw new ServiceUtils_Exception('bot');
                }

                $errorArray = array();
                $clientName = trim(strip_tags(($this->getControlValue('clientname'))));
                $clientFamilyName = trim(strip_tags(($this->getControlValue('clientfamilyname'))));
                $clientPhone = trim(strip_tags(($this->getControlValue('clientphone'))));
                $product = Shop::Get()->getShopService()->getProductByID($this->getControlValue('roomtype'));

                if ($clientName && $clientFamilyName) {
                    $clientName = $clientName.' '.$clientFamilyName;
                } elseif($clientName && !$clientFamilyName) {
                    $clientName = $clientName;
                } elseif(!$clientName && $clientFamilyName) {
                    $clientName = $clientFamilyName;
                } else {
                    $errorArray[] = 'name';
                }

                if (!$clientPhone) {
                    $errorArray[] = 'phone';
                } elseif (!Checker::CheckPhone($clientPhone)) {
                    $errorArray[] = 'phone';
                }

                if ($errorArray) {
                    $this->setValue('errorArray',$errorArray);
                } else {
                    try {
                        $client = Shop::Get()->getUserService()->addUserClient(
                            $clientName,
                            false, // no login
                            false, // no password
                            false,
                            $clientPhone,
                            false, // address
                            false, // company
                            false, // department
                            false, // time
                            false, // comment admin
                            'order' // group type
                        );
                    } catch (Exception $e) {
                        try{
                            $client = $this->getUser();
                        } catch (Exception $e) {
                            $ex = new ServiceUtils_Exception();
                            $ex->addError('user');
                            throw $ex;
                        }

                    }

                    // оформляем заказ
                    $order = Kazakh::Get()->getKazakhService()->makeOrderQuick(
                        $client,
                        $product,
                        $clientPhone,
                        $clientName,
                        $this->getControlValue('datefrom'),
                        $this->getControlValue('dateto'),
                        $this->getControlValue('comment'),
                        $this->getControlValue('peoplecount')
                    );

                    $this->setValue('orderSuccess',1);
                }

                SQLObject::TransactionCommit();

            } catch (ServiceUtils_Exception $e) {  //print_r($e->getErrorsArray());exit;
                SQLObject::TransactionRollback();
            }
        } else {
            try {
                $user = $this->getUser();
                $this->setControlValue('qoname',$user->getName());
                $this->setControlValue('qoemail',$user->getEmail());
                $this->setControlValue('qophone',$user->getPhone());
            } catch (Exception $e) {

            }
        }
    }

}