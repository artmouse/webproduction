<?php
class SmsOrderStatusNewLogicClass {

    /**
     * Формирование текста для смс-отчета после подачи заявки клиентом
     *
     * @return string
     */
    public function getText() {

        $text = 'Спасибо за Вашу заявку №[orderid]. Мы свяжемся с Вами ';
        $day = date('l');

        if ($day == 'Saturday') {
            // суббота
            $text.= 'в понедельник, после 10:00.';

        } elseif ($day == 'Sunday') {
            // воскресенье
            $text.= 'завтра, после 10:00.';

        } else {

            $hour = date('G');

            if ($hour > 17) {
                if ($day == 'Friday') {
                    // пятница, конец дня
                    $text.= 'в понедельник, после 10:00.';

                } else {
                    // будние, конец дня
                    $text.= 'завтра, после 10:00.';

                }

            } else {
                // будние, не конец дня
                $text.= 'в ближайшее время.';
            }

        }

        return $text;
    }

}