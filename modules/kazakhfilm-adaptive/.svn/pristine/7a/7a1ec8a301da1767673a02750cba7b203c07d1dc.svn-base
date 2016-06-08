<?php
class KazakhService extends ServiceUtils_AbstractService {

    /**
     * @param User $client
     * @param ShopProduct $product
     * @param $phone
     * @param $name
     * @param $datefrom
     * @param $dateto
     * @param $comment
     * @param $peoplecount
     * @return ShopOrder
     * @throws ServiceUtils_Exception
     * @throws Exception
     */
    public function makeOrderQuick(User $client, ShopProduct $product, $phone, $name, $datefrom, $dateto, $comment, $peoplecount) {
        /**
         * Общий алгоритм оформления заказа:
         *
         * 1. При оформлении заказа все суммы товаров и сумма заказа будет
         * в системной валюте.
         * 2. Будет выбрано активное юрлицо по умолчанию - и оно будет выставлено
         * в заказ.
         * 3. Все стоимости товаров будут приведены к полной стоимости включая НДС
         * (если НДС указан в самом товаре). НДС контрактора не будет использоваться.
         *
         * Уже в управлении заказом чтобы посчитать НДС нужно будет от суммы заказа снять
         * процент НДС.
         */
        try {
            SQLObject::TransactionStart();

            $comment = trim(strip_tags($comment));

            // получаем системную валюту, в которой будем оформлять заказ
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

            // поиск статуса заказа по умолчанию
            try {
                $statusDefault = new ShopOrderStatus();
                $statusDefault->setDefault(1);
                $statusDefault->select();
            } catch (Exception $e) {

            }

            // поиск активного юридического лица
            try {
                $contractor = Shop::Get()->getShopService()->getContractorDefault();
                $contractorID = $contractor->getId();
                $contractorTax = $contractor->getTax();
            } catch (Exception $e) {
                $contractorID = 0;
                $contractorTax = 0;
            }

            // оформление заказа
            $order = new ShopOrder();
            $order->setCdate(date('Y-m-d H:i:s'));

            // оформляем заказ на клиента
            $order->setUserid($client->getId());

            // параметры юзера из формы
            $order->setClientname($name);
            $order->setClientphone($phone);
            //$order->setClientemail($email);
            $order->setStatusid($statusDefault->getId());
            // дата до которой нужно выполнить заказ
            $order->setDateto(DateTime_Object::Now()->addDay((int) Shop::Get()->getSettingsService()->getSettingValue('order-dateto-days'))->__toString());
            // юрлицо (контрактор)
            $order->setContractorid($contractorID);

            $order->setPeoplecount($peoplecount);
            $order->setClientdatefrom($datefrom);
            $order->setClientdateto($dateto);
            $order->setComments($comment);

            // кто автор заказа
            try {
                $order->setAuthorid(Shop::Get()->getUserService()->getUser()->getId());
            } catch (Exception $authorEx) {

            }

            // кто менеджер заказа
            try {
                $manager = Shop::Get()->getUserService()->getUser();
                if ($manager->isManager()) {
                    $order->setManagerid($manager->getId());
                }
            } catch (Exception $managerEx) {

            }

            // вставляем заказ
            $order->insert();

            // сумма заказа
            $sum = 0;
            $count = 0;

            // приводим стоимость товара к НДС и скидке в самом товаре, к валюте заказа
            $price = $product->makePriceWithTax($currencyDefault);

            // вставляем запись
            $op = new ShopOrderProduct();
            $op->setOrderid($order->getId());
            $op->setProductid($product->getId());
            $op->setProductcount(1); // 1 штука
            $op->setProductname($product->getName());
            $op->setProductprice($price);
            $op->setCurrencyid($currencyDefault->getId());
            $op->insert();

            // считаем сумму заказа.
            // при подсчете приводим цену к округлению НДС контрактора
            $priceWithoutTax = Shop::Get()->getShopService()->calculateSum(
                $price,
                $contractorTax,
                0,
                0,
                true, // return sum
                false, // + vat tax
                false // without discount
            );

            $sum = round($priceWithoutTax * $op->getProductcount(), 2);

            // увеличиваем счетчик заказа товаров на +1
            $product->setOrdered($product->getOrdered() + 1);
            $product->setLastordered(date('Y-m-d H:i:s'));
            $product->update();

            $count ++;

            // если нет строк - нет заказа
            if (!$count) {
                throw new ServiceUtils_Exception('count');
            }

            if ($contractorTax) {
                $sum *= (1 + $contractorTax / 100);
            }

            // автоопределение скидки
            $value = 0;
            $discount = false;
            $discounts = Shop::Get()->getShopService()->getDiscountAll();
            while ($x = $discounts->getNext()){
                // если скидка может применятся автоматически
                if ($x->getMinstartsum() > 0) {
                    // конвертируем сумму заказа в валюту скидки
                    $sumDiscount = Shop::Get()->getCurrencyService()->convertCurrency(
                        $sum,
                        $currencyDefault,
                        $x->getCurrency());

                    if ($x->getMinstartsum() <= $sumDiscount){
                        // ищем максимально возможную скидку
                        $x_value = $x->makeDiscountValue($sum, $currencyDefault);
                        if ($x_value > $value){
                            $value = $x_value;
                            $discount = clone $x;
                        }
                    }
                }
            }

            if ($discount) {
                $order->setDiscountid($discount->getId());
                $order->setDiscountsum($discount->makeDiscountValue($sum, $currencyDefault));
                $sum = $discount->applyDiscount($sum, $currencyDefault);
                $sum = round($sum, 2);
            }

            // увеличиваем стоимость заказа на сумму доставки
            // Внимание! Доставка в сумме заказа уже не фигурирует!
            // $sum += $deliveryPrice;

            // записываем сумму заказа и валюту
            $order->setSum($sum);
            $order->setCurrencyid($currencyDefault->getId());

            // формируем записываем Hash заказа
            // для трек-ссылки заказа
            $order->setHash(md5($order->getId().$order->getClientname().$order->getClientphone().$order->getCdate()));

            // обновляем заказ
            $order->update();

            // fire event
            $event = Events::Get()->generateEvent('shopOrderAddAfter');
            $event->setOrder($order);
            $event->notify();

            // отправляем сообщения всем
            $this->_orderSendmail($order);

            // отправляем SMS клиенту и админу
            $this->_orderSMS($order);

            SQLObject::TransactionCommit();

            // запись в XML/CSV после успешной транзакции!
            /*$this->_orderXML($order);
            $this->_orderCSV($order);*/

            return $order;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Отправить сообщение на email о заказе
     * (о изменении его статуса)
     *
     * @param ShopOrder $order
     */
    public function _orderSendmail(ShopOrder $order) {
        // отправка обычная (только клиенту)
        /*$tpl = $order->getStatus()->getMessage();
        if ($tpl && $order->getClientemail()) {
            $letter = $this->_orderSendmailLetter($order, $tpl);

            $letter->addEmail($order->getClientemail());
            $letter->send();
        }*/

        // отправка менеджеру и администраторам
        $tpl = $order->getStatus()->getMessageadmin();
        if ($tpl) {
            $letter = $this->_orderSendmailLetter($order, $tpl);

            // получаем все емейлы на которые нужно отправить заказ
            $emailToArray = $this->_getNotificationEmailArray();
            foreach ($emailToArray as $e) {
                $letter->addEmail($e);
            }

            $letter->send();
        }
    }

    /**
     * @param ShopOrder $order
     * @param unknown_type $tpl
     * @return MailUtils_SmartySender
     */
    private function _orderSendmailLetter(ShopOrder $order, $tpl) {
        $letter = MailUtils_SmartySender::CreateFromTemplateData($tpl);
        $letter->setEmailFrom(Shop::Get()->getSettingsService()->getSettingValue('reverse-email'));

        // получаем валюту заказа
        $currencyDefault = $order->getCurrency();

        // оплачен ли заказ?
        $canDownload = $order->getStatus()->getDownloadable();

        /**
         * Важно:
         * Фактически, заказ может быть оформлен в гривне,
         * но внутри заказ могут быть строки в разных валютах.
         * В таком случае уведомления нужно высылать в валюте заказа, то есть
         * все конвертируем в гривны.
         */

        $a = array();
        $orderproducts = $order->getOrderProducts();
        while ($op = $orderproducts->getNext()) {
            $url = false;
            /*if ($canDownload) {
                try {
                    $url = $this->makeProductDownloadURL($op->getProduct());
                    $url = Engine::Get()->getProjectURL().'/'.$url;
                } catch (Exception $e) {

                }
            }*/

            $a[] = array(
                'name' => $op->getProductname(),
                'count' => $op->getProductcount(),
                'price' => $op->makePrice($currencyDefault),
                'productid' => $op->getProduct()->makeCode(),
                'sum' => $op->makeSum($currencyDefault),
                'url' => $url,
                'comment' => $op->getComment(),
            );
        }

        $letter->assign('basketsArray', $a);
        $letter->assign('clientname', htmlspecialchars($order->getClientname()));
        $letter->assign('clientemail', htmlspecialchars($order->getClientemail()));
        $letter->assign('clientphone', htmlspecialchars($order->getClientphone()));
        $letter->assign('clientaddress', htmlspecialchars($order->getClientaddress()));
        $letter->assign('clientcontacts', nl2br(htmlspecialchars($order->getClientcontacts())));
        $letter->assign('comments', nl2br(htmlspecialchars($order->getComments())));
        $letter->assign('trackurl', Engine::Get()->getProjectURL().'/order/'.$order->getHash().'/');
        $letter->assign('signature', Shop::Get()->getSettingsService()->getSettingValue('letter-signature'));
        // накладная доставки
        $letter->assign('deliveryNote', htmlspecialchars($order->getDeliverynote()));
        if ($order->getManagerid()) {
            try {
                $manager = $order->getManager();
                $letter->assign('managername', htmlspecialchars($manager->getName()));
                $letter->assign('manageremail', htmlspecialchars($manager->getEmail()));
                $letter->assign('managerphone', htmlspecialchars($manager->getPhone()));
            } catch (Exception $e) {

            }
        }

        $letter->assign('status', htmlspecialchars($order->getStatus()->getName()));
        $letter->assign('date', DateTime_Formatter::DateTimeRussianGOST($order->getCdate()));
        $letter->assign('projecturl', Engine::Get()->getProjectURL());
        $letter->assign('orderid', $order->getId());
        $letter->assign('shopname', Shop::Get()->getSettingsService()->getSettingValue('shop-name'));

        // сумма и валюта заказа
        $letter->assign('ordersum', $order->getSum() + $order->getDeliveryprice()); // c учетом доставки
        $letter->assign('deliveryPrice', $order->getDeliveryprice()); // стоимость доставки
        $letter->assign('discountSum', $order->getDiscountsum()); // скидка
        $letter->assign('ordercurrency', $currencyDefault->getSymbol());

        return $letter;
    }

    /**
     * Получить список notification-емейлов
     *
     * @return array
     */
    private function _getNotificationEmailArray($emailKey = 'email-orders') {
        $orderEmails = Shop::Get()->getSettingsService()->getSettingValue($emailKey);
        return $this->_extractEmailArray($orderEmails);
    }

    /**
     * Получить список notification-емейлов
     *
     * @param string $text
     * @return array
     */
    private function _extractEmailArray($text) {
        $text = str_replace(array("\r", "\n", "\t"), ' ', $text);
        $text = preg_replace("/([\s\,\;]+)/ius", ' ', $text);
        $orderEmailsArray = explode(' ', $text);
        $a = array();
        foreach ($orderEmailsArray as $x) {
            $x = trim($x);
            if (Checker::CheckEmail($x)) {
                $a[] = $x;
            }
        }
        return $a;
    }

    /**
     * Отправить сообщение по SMS о заказе
     * (о изменении его статуса)
     *
     * @param ShopOrder $order
     */
    public function _orderSMS(ShopOrder $order) {
        $apiLogin = Shop::Get()->getSettingsService()->getSettingValue('turbosms-login');
        $apiPassword = Shop::Get()->getSettingsService()->getSettingValue('turbosms-password');
        $apiSender = Shop::Get()->getSettingsService()->getSettingValue('turbosms-sender');

        if (!$apiLogin || !$apiPassword || !$apiSender) {
            return;
        }

        // отправка юзеру
        $tpl = $order->getStatus()->getSMS();
        if ($tpl) {
            $phone = $order->getClientphone();
            if (strlen($phone) >= 12) {
                try {
                    PackageLoader::Get()->import('SMSUtils');

                    $sender = $this->_orderSMSLetter($order, $tpl);
                    $tpl = $this->_getMessageByTpl($order, $tpl);
                    $sender->send($apiSender, $phone, $tpl);
                } catch (Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
            }
        }

        // отправка юзеру
        $tpl = $order->getStatus()->getSmsadmin();
        if ($tpl) {
            $adminPhone = Shop::Get()->getSettingsService()->getSettingValue('turbosms-admin-phone');
            if (strlen($adminPhone) >= 12) {
                try {
                    PackageLoader::Get()->import('SMSUtils');

                    $sender = $this->_orderSMSLetter($order, $tpl);
                    $tpl = $this->_getMessageByTpl($order, $tpl);
                    $sender->send($apiSender, $adminPhone, $tpl);
                } catch (Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
            }
        }
    }

    private function _orderSMSLetter(ShopOrder $order, $tpl) {
        PackageLoader::Get()->import('SMSUtils');

        $sender = new SMSUtils(new SMSUtils_SenderQueDB());

        return $sender;
    }

    /**
     * @param ShopOrder $order
     * @param $tpl
     * @return mixed
     */
    private function _getMessageByTpl(ShopOrder $order, $tpl ) {
        $tpl = str_replace('[orderid]', $order->getId(), $tpl);
        $tpl = str_replace('[clientname]', $order->getClientname(), $tpl);
        $tpl = str_replace('[clientemail]', $order->getClientemail(), $tpl);
        $tpl = str_replace('[clientphone]', $order->getClientphone(), $tpl);
        $tpl = str_replace('[clientaddress]', $order->getClientaddress(), $tpl);

        // получаем валюту заказа
        $currencyDefault = $order->getCurrency();

        if ($order->getManagerid()) {
            try {
                $manager = $order->getManager();

                $tpl = str_replace('[managername]', $manager->getName(), $tpl);
                $tpl = str_replace('[manageremail]', $manager->getEmail(), $tpl);
                $tpl = str_replace('[managerphone]', $manager->getPhone(), $tpl);
            } catch (Exception $e) {

            }
        }

        // статус и дата заказа
        $tpl = str_replace('[status]', $order->getStatus()->getName(), $tpl);
        $tpl = str_replace('[date]', DateTime_Formatter::DateTimeRussianGOST($order->getCdate()), $tpl);

        // сумма и валюта заказа
        $tpl = str_replace('[ordersum]', $order->getSum(), $tpl);
        $tpl = str_replace('[ordercurrency]', $currencyDefault->getSymbol(), $tpl);

        return $tpl;
    }

    public function addGuestBook($name,$email,$response) {
        try {
            SQLObject::TransactionStart();
            $ex = new ServiceUtils_Exception();
            $response = trim(strip_tags($response));
            $name = trim(strip_tags($name));
            $email = trim(strip_tags($email));
            if (empty($name)) {
                $ex->addError('name');
            }
            if (empty($response)) {
                $ex->addError('response');
            }
            if (!Checker::CheckEmail($email)) {
                $ex->addError('email');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            $guestbook = new XShopGuestBook();

            $cdate = date('Y-m-d H:i:s');

            $guestbook->setText($response);
            $guestbook->setCdate($cdate);
            $guestbook->setName($name);
            $guestbook->setEmail($email);
            $guestbook->setDone(0);
            $guestbook->insert();

            // sendmail
            $tpl = Shop::Get()->getSettingsService()->getSettingValue('letter-shop-guestbook-response');
            if ($tpl) {
                $sender = MailUtils_SmartySender::CreateFromTemplateData($tpl);
                $sender->setEmailFrom(Shop::Get()->getSettingsService()->getSettingValue('reverse-email'));
                $sender->addEmail(Shop::Get()->getSettingsService()->getSettingValue('email-guestbook'));

                $sender->setEmailFrom($email);
                $sender->assign('name', $name);

                $sender->assign('response', $response);
                $sender->assign('signature', Shop::Get()->getSettingsService()->getSettingValue('letter-signature'));
                $sender->send();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }


    /**
     * Обновить валюту
     *
     * @param $currencyID
     * @param $rate
     * @param $symbol
     * @param $select
     * @param $hidden
     * @param $autoupdate
     * @throws Exception
     */
    public function updateCurrency($currencyID, $rate, $symbol, $default, $hidden, $autoupdate, $sort) {
        try {
            SQLObject::TransactionStart();

            $currency = Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID);

            $rate = trim($rate);
            $rate = str_replace(',', '.', $rate);
            $rate = str_replace(' ', '.', $rate);
            $symbol = trim($symbol);

            $currency->setRate($rate);
            $currency->setHidden($hidden);
            $currency->setAutoupdate($autoupdate);
            $currency->setSort($sort);
            $currency->setSymbol($symbol);
            $currency->setDefault($default);
            $currency->update();

            SQLObject::TransactionCommit();
        } catch(Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }





}