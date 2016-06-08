<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_PaymentFeedback {

    public function process() {
        $date = DateTime_Object::Now()->addDay(-1)->setFormat('Y-m-d')->__toString();

        $issueIDArray = array();

        $payments = PaymentService::Get()->getPaymentsAll();
        $payments->addWhere('pdate', $date.' 00:00:00', '>=');
        $payments->addWhere('pdate', $date.' 23:59:59', '<=');
        $payments->addWhere('amount', 0, '>');
        $payments->addWhere('linkkey', '', '!=');
        while ($x = $payments->getNext()) {
            try {
                // определяем клиента
                $client = $x->getClient();

                // определяем менеджера
                try {
                    $manager = $x->getOrder()->getManager();
                } catch (Exception $managerEx) {
                    $manager = $client->getManager();
                }

                // отправляем уведомление насчет client
                $issueIDArray[] = NotifyService::Get()->addNotify(
                $manager,
                'contact-'.$client->getId().'-payment-feedback-'.$x->getId(),
                'Благодарность за оплату',
                "Вчера мы получили платеж на сумму {$x->getAmount()} {$x->getCurrency()->getSymbol()} от клиента {$client->makeName(false)}. Рекомендуем сегодня позвонить клиенту и поблагодарить его за оплату.",
                false,
                1, // high
                $client->getId()
                );

                // отправляем уведомление насчет client.parentid
                try {
                    $parent = Shop::Get()->getUserService()->getUserByID(
                    $client->getParentid()
                    );

                    $issueIDArray[] = NotifyService::Get()->addNotify(
                    $manager,
                    'contact-'.$parent->getId().'-payment-feedback-'.$date.'-'.$x->getId().'-parent',
                    'Реферальные/благодарность за оплату',
                    "Вчера мы получили платеж на сумму {$x->getAmount()} {$x->getCurrency()->getSymbol()} от клиента {$client->makeName(false)}, которого отрекомендовал нам {$parent->makeName(false)}. Рекомендуем сегодня позвонить партнеру и поблагодарить его за рекомендацию, возможно согласовать получение реферальных.",
                    false,
                    1, // high
                    $parent->getId()
                    );
                } catch (Exception $parentEx) {

                }

            } catch (Exception $e) {

            }
        }

        return $issueIDArray;
    }

}
