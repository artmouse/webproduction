<?php
class orders_report_funnel extends Engine_Class {

    public function process() {
        $metrikaAuthToken = Shop::Get()->getSettingsService()->getSettingValue('integration-yandex-metrika-token');
        $metrikaCounterID = Shop::Get()->getSettingsService()->getSettingValue('integration-yandex-metrika-counterid');

        if (!$metrikaAuthToken || !$metrikaCounterID) {
            $this->setValue('error', 'metrika');
            return;
        }

        $dateFrom = $this->getArgumentSecure('datefrom', 'date');
        $dateTo = $this->getArgumentSecure('dateto', 'date');

        if ($dateFrom) {
            $dateFrom .= ' 00:00:00';
        } else {
            $dateFrom = DateTime_Object::Now()->addDay(-7)->__toString();
            $this->setControlValue('datefrom', $dateFrom);
        }

        if ($dateTo) {
            $dateTo .= ' 23:59:59';
        } else {
            $dateTo = DateTime_Object::Now()->__toString();
            $this->setControlValue('dateto', $dateTo);
        }

        $dateFrom_metrika = DateTime_Object::FromString($dateFrom)->setFormat('Ymd')->__toString();
        $dateTo_metrika = DateTime_Object::FromString($dateTo)->setFormat('Ymd')->__toString();

        $url = 'http://api-metrika.yandex.ru/stat/traffic/summary.json?oauth_token='.$metrikaAuthToken.'&id='.$metrikaCounterID.'&date1='.$dateFrom_metrika.'&date2='.$dateTo_metrika.'&group=month';
        $json = @json_decode(file_get_contents($url));
        if (!$json) {
            $this->setValue('error', 'metrika');
            return;
        }

        $visitors = 0;
        $visitors_new = 0;
        $pageviews = 0;
        $denials = 0;
        $orderCount = 0;
        $basketCount = 0;
        $userCount = 0;
        $callCount = 0;
        $feedbackCount = 0;

        foreach ($json->data as $x) {
            $visitors += (int) $x->visitors.'';
            $visitors_new += (int) $x->new_visitors.'';
            $pageviews += (int) $x->page_views.'';
            $denials += ((int) $x->visits.'') * ((float) $x->denial.'');
        }

        $denials = round($denials);

        // считаем корзины
        $baskets = new ShopBasket();
        $baskets->addWhere('cdate', $dateFrom, '>=');
        $baskets->addWhere('cdate', $dateTo, '<=');
        $baskets->setGroupByQuery('sid');
        $basketCount = $baskets->getCount();

        // считаем заказы
        $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
        $orders->addWhere('cdate', $dateFrom, '>=');
        $orders->addWhere('cdate', $dateTo, '<=');
        $orderCount = $orders->getCount();

        // к корзине нужно добавить все заказы (так как они прошли через корзину)
        $basketCount += $orderCount;

        // считаем пользователей
        $users = Shop::Get()->getUserService()->getUsersAll();
        $users->addWhere('cdate', $dateFrom, '>=');
        $users->addWhere('cdate', $dateTo, '<=');
        $userCount = $users->getCount();

        // считаем количество звонков
        $calls = Shop::Get()->getCallbackService()->getCallbackAll();
        $calls->addWhere('cdate', $dateFrom, '>=');
        $calls->addWhere('cdate', $dateTo, '<=');
        $callCount = $calls->getCount();

        // считаем количество писем
        $feedbacks = Shop::Get()->getFeedbackService()->getFeedbackAll();
        $feedbacks->addWhere('cdate', $dateFrom, '>=');
        $feedbacks->addWhere('cdate', $dateTo, '<=');
        $feedbackCount = $feedbacks->getCount();

        // считаем количество просмотренных товаров
        $productviews = new XShopProductView();
        $productviews->addWhere('cdate', $dateFrom, '>=');
        $productviews->addWhere('cdate', $dateTo, '<=');
        $productviews = $productviews->getCount();

        // считаем конверсии
        if ($visitors > 0) {
            $conversion_visitors2orders = round($orderCount / $visitors * 100, 2);
            $conversion_visitors2denials = round($denials / $visitors * 100, 2);
            $conversion_visitors2baskets = round($orderCount / $visitors * 100, 2);
            $conversion_visitors2users = round($userCount / $visitors * 100, 2);
            $conversion_visitors2activity = round($userCount + $feedbackCount + $callCount + $basketCount / $visitors * 100, 2); // заказы уже посчитаны в корзинах
        } else {
            $conversion_visitors2orders = 0;
            $conversion_visitors2denials = 0;
            $conversion_visitors2baskets = 0;
            $conversion_visitors2users = 0;
            $conversion_visitors2activity = 0;
        }
        if ($basketCount > 0) {
            $conversion_baskets2orders = round($orderCount / $basketCount * 100, 2);
        } else {
            $conversion_baskets2orders = 0;
        }

        // передаем данные
        $this->setValue('visitors', $visitors);
        $this->setValue('visitors_new', $visitors_new);
        $this->setValue('pageviews', $pageviews);
        $this->setValue('productviews', $productviews);
        $this->setValue('denials', $denials);
        $this->setValue('baskets', $basketCount);
        $this->setValue('orders', $orderCount);
        $this->setValue('users', $userCount);
        $this->setValue('feedbacks', $feedbackCount);
        $this->setValue('calls', $callCount);
        $this->setValue('visitors2orders', $conversion_visitors2orders);
        $this->setValue('visitors2denials', $conversion_visitors2denials);
        $this->setValue('visitors2baskets', $conversion_visitors2baskets);
        $this->setValue('visitors2users', $conversion_visitors2users);
        $this->setValue('visitors2activity', $conversion_visitors2activity);
        $this->setValue('baskets2orders', $conversion_baskets2orders);
    }

}