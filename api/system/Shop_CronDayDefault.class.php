<?php
/**
 * CronDayDefault
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 *
 * @copyright WebProduction
 *
 * @package OneBox
 */
class Shop_CronDayDefault implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        // Отправляем писмьо клиентам, с просьбой оставить комментарий.
        if (Shop::Get()->getSettingsService()->getSettingValue('send-auto-feedback')) {
            $this->_autoFeedback();
        }

        // чистка корзины
        ModeService::Get()->verbose('Clear 1 year old baskets...');
        $x = new ShopBasket();
        $x->addWhere('cdate', DateTime_Object::Now()->addYear(-1)->__toString(), '<');
        $x->setUserid(0); // не удалять корзины пользователей
        $x->delete(true);

        ModeService::Get()->verbose('Clear expiried download urls...');
        $x = new XShopDownloadURL();
        $x->addWhereQuery('edate', DateTime_Object::Now()->__toString(), '>');
        $x->delete(true);

        // issue #56187 - auto clean
        if (date('d') == 1) {
            try {
                ModeService::Get()->verbose('Monthly clear cache...');
                Engine::GetCache()->clearCache();
            } catch (Exception $e) {

            }
        }

        // считаем рейтинг товаров
        Shop::Get()->getShopService()->calculateProductRating();

        // обновляем валюты
        Shop::Get()->getCurrencyService()->autoupdateCurrencyRates();

        // уведомления о наличии товаров
        Shop::Get()->getProductsNoticeOfAvailabilityService()->processNoticeOfAvail();

        // Пересчитывае кол-во товаров в категориях
        // @todo
        ModeService::Get()->verbose('Recalculate product count in categories...');
        $connection = ConnectionManager::Get()->getConnectionDatabase();
        $connection->query("UPDATE `shopcategory` SET `productcount` = 0");
        for ($i = 1; $i <= 10; $i++) {
            $connection->query(
                "UPDATE `shopcategory` SET `productcount` = productcount + (SELECT count(*) FROM `shopproduct` WHERE
                `category{$i}id` = `shopcategory`.`id` AND `hidden` = '0' AND `deleted` = '0')"
            );
        }

        // Пересчитывае кол-во товаров в брендах
        // @todo
        ModeService::Get()->verbose('Recalculate product count in brands...');
        $connection->query(
            "UPDATE `shopbrand` SET `productcount` = (SELECT count(*) FROM `shopproduct` WHERE
            `brandid` = `shopbrand`.`id` AND `hidden` = '0' AND `deleted` = '0')"
        );
        
        $this->_takeFileSeoXml();
    }

    private function _autoFeedback() {
        ModeService::Get()->verbose('Send auto feedbacks for customer orders...');

        // Получаем все заказы, которым еще не отправляли письмо
        $orders = Shop::Get()->getShopService()->getOrdersAll();

        // $orders->addWhere('dateclosed', DateTime_Object::Now()->addDay(-21)->__toString(), '<');
        $orders->addWhereQuery(
            '(`dateclosed` < "' . DateTime_Object::Now()->addDay(-21)->__toString() . '" &&
            `dateclosed` != "0000-00-00 00:00:00")'
        );
        $orders->addWhere('send_mail_comment', '0', '=');
        $orders->addWhere('issue', '0', '=');
        $orders->addWhere('outcoming', '0', '=');
        $orders->addWhere('forgift', '0', '=');

        while ($x = $orders->getNext()) {
            try {
                $user = $x->getClient();

                // Проверяем email.  Если email не валидный, то и отправлять некуда
                if ($user->getEmail() && Checker::CheckEmail($user->getEmail())) {
                    // Получаем товары по данному заказу
                    $products = $x->getOrderProducts();

                    // Формируем письмо
                    $tpl = Shop::Get()->getSettingsService()->getSettingValue('letter-auto-feedback');

                    if (!$tpl) {
                        return;
                    }

                    $letter = MailUtils_SmartySender::CreateFromTemplateData($tpl);
                    $letter->setTemplate(Shop::Get()->getShopService()->getMailTemplate());
                    $letter->setEmailFrom(Shop::Get()->getSettingsService()->getSettingValue('reverse-email'));
                    $letter->addEmail($user->getEmail());


                    // Нкапливаем массив названий товаров, и ссылки на товар
                    $productsArray = array();
                    $i = 1;
                    while ($p = $products->getNext()) {
                        try {
                            $product = $p->getProduct();
                            if (!$product->getHidden() || !$product->getDeleted()) {
                                $productsArray[$i] = array(
                                    'name' => $product->makeName(),
                                    'url' => $product->makeURL(),
                                    'imageUrl' => "http://" . Engine::Get()->getConfigField('project-host') .
                                        $product->makeImageThumb(150)
                                );
                                $i++;
                            }
                        } catch (Exception $e) {

                        }
                    }

                    if (!count($productsArray)) {
                        return;
                    }

                    $letter->assign('cdate', date("d.m.Y", strtotime($x->getCdate())));
                    if (Engine::Get()->getConfigFieldSecure('project-box-custom-order-number')) {
                        $letter->assign('orderNumber', $x->getNumber());
                    } else {
                        $letter->assign('orderNumber', $x->getId());
                    }
                    $letter->assign('userName', $user->makeName(true, 'fm'));
                    $letter->assign('productsArray', $productsArray);

                    // Сигнатура
                    $letter->assign(
                        'signature',
                        Shop::Get()->getSettingsService()->getSettingValue('letter-signature')
                    );

                    // Отправляем письмо.
                    $letter->send();
                }

                // Указываем заказу, что письмо уже отправлено, или была попытка отправить письмо.
                $x->setSend_mail_comment(1);
                $x->update();

            } catch (Exception $e) {

            }

        }
    }
    
    private function _takeFileSeoXml() {
        $file = file_get_contents('http://seo.webproduction.ua/index.xml');
        if ($file != false) {
            file_put_contents(MEDIA_PATH.'/relink.xml', $file);
        }
    }
}