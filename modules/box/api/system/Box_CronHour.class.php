<?php
/**
 * Box Cron Hour
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   OneBox
 */
class Box_CronHour implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        // распределение контактов по группам
        Shop::Get()->getUserService()->processUserGroups();

        // каждый час проверяем параметры событий
        try {
            EventService::Get()->processEventParametersAll(false);
        } catch (Exception $e) {
            print $e;
        }

        // проверка всех уведомлений
        try {
            NotifyService::Get()->process();
        } catch (Exception $e) {
            print $e;
        }

        // KPI
        KPIService::Get()->processKPI();

        $this->_checkKey();

        // перерассчет рабочего времени
        Shop::Get()->getUserService()->workTimeUsers();

        // проверка уведомлений на валидность
        Shop::Get()->getNotificationService()->processNotificationValid();

        $this->_checkCalls();
    }

    private function _checkCalls() {
        $eventId = Shop::Get()->getShopService()->getSystemNoticeData('cron-hour-check-calls');

        if (!$eventId) {
            $eventId = 0;
        }

        $calls = new ShopEvent();
        $calls->setType('call');
        $calls->addWhere('id', $eventId, '>');
        $calls->addWhereQuery("`fromuserid` != '0' AND `touserid` != '0'");
        $calls->setOrder('id');

        $lastCalls = $eventId;
        while ($x = $calls->getNext()) {
            $lastCalls = $x->getId();

            // manager call to client
            $company = false;
            try {
                $to = $x->getToContact();
                $company = Shop::Get()->getShopService()->getCompanyByName($to->getCompany());
            } catch (Exception $ecompany) {

            }

            $orders = Shop::Get()->getShopService()->getOrdersAll(false, true);
            if ($company) {
                $orders->addWhereQuery('(`userid` = "'.$x->getTouserid().'" OR `userid` = "'.$company->getId().'")');
                if ($company->getId() > $x->getTouserid()) {
                    $orders->setOrder('id');
                } else {
                    $orders->setOrder('id', 'DESC');
                }
            } else {
                $orders->setUserid($x->getTouserid());
            }
            $orders->addWhereQuery(
                "`id` IN (SELECT `orderid` FROM `shoporderlogview` WHERE `userid` = '".$x->getFromuserid().
                "' AND `cdate` > '".DateTime_Object::FromString($x->getCdate())->addMinute(-5)->__toString().
                "' AND `cdate` < '".DateTime_Object::FromString($x->getCdate())->addMinute(5)->__toString()."')"
            );
            if ($orders = $orders->getNext()) {
                Shop::Get()->getShopService()->addOrderCall($orders, $x);
                continue;
            }



            //client call to manager
            $orders = Shop::Get()->getShopService()->getOrdersAll(false, true);

            $company = false;
            try {
                $from = $x->getFromContact();
                $company = Shop::Get()->getShopService()->getCompanyByName($from->getCompany());
            } catch (Exception $ecompany) {

            }
            if ($company) {
                $orders->addWhereQuery('(`userid` = "'.$x->getFromuserid().'" OR `userid` = "'.$company->getId().'")');
                if ($company->getId() > $x->getFromuserid()) {
                    $orders->setOrder('id');
                } else {
                    $orders->setOrder('id', 'DESC');
                }
            } else {
                $orders->setUserid($x->getFromuserid());
            }
            $orders->addWhereQuery(
                "`id` IN (SELECT `orderid` FROM `shoporderlogview` WHERE `userid` = '".$x->getTouserid().
                "' AND `cdate` > '".DateTime_Object::FromString($x->getCdate())->addMinute(-5)->__toString().
                "' AND `cdate` < '".DateTime_Object::FromString($x->getCdate())->addMinute(5)->__toString()."')"
            );
            if ($orders = $orders->getNext()) {
                Shop::Get()->getShopService()->addOrderCall($orders, $x);
            }
        }

        Shop::Get()->getShopService()->addSystemNotice('cron-hour-check-calls', $lastCalls);
    }

    private function _checkKey() {
        ModeService::Get()->verbose('Get license key...');

        $key = Engine::Get()->getConfigFieldSecure('box-key');

        $result = false;

        if ($key) {
            $url = 'http://license.onebox-system.com/';

            $dataArray = array();
            $dataArray['key'] = $key;
            $postdata = http_build_query($dataArray);

            $optionArray = array(
                'http' => array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                ),
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false
                ),
            );

            $context  = stream_context_create($optionArray);

            $result = (int) file_get_contents($url, false, $context);

        }

        if ($result === false) {
            $result = 1;
        }

        $file = MEDIA_PATH.'/tmp/key';
        file_put_contents($file, $result, LOCK_EX);
    }

}