<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_WorkToday {

    public function process() {
        /**
         * Если сегодня менеджеры не работали - слать им уведомление на почту.
         * Уведомления начинаюся после середины рабочего дня, каждый час.
         * Выходные пропускаются.
         */

        if (date('D') == 'Sun') {
            return;
        }
        if (date('D') == 'Sat') {
            return;
        }

        if (date('H') < '12') {
            return;
        }

        if (date('i') != '00') {
            return;
        }

        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');

        $managers = Shop::Get()->getUserService()->getUsersManagers();
        $managers->setLevel(2);
        while ($x = $managers->getNext()) {

            if (date('Y-m-d') != DateTime_Formatter::DateISO9075($x->getAdate())) {
                // менеджер не работал

                // шлем ему письмо
                if ($x->getEmail()) {
                    $text = '';
                    $text .= "{$x->makeName()}!\n";
                    $text .= "\n";
                    $text .= "К сожалению, сегодня с утра Вы еще не заходили в систему OneBox и не работали в ней.\n";
                    $text .= "Настоятельно просим Вас выполнять свои обязанности.\n";
                    $text .= "\n";
                    $text .= Engine::Get()->getProjectURL()."\n";
                    $text .= "\n";
                    $text .= "--\n";
                    $text .= "Автоматическое уведомление OneBox.\n";

                    $letter = new MailUtils_Letter($emailFrom, $x->getEmail(), '[OneBox]', $text);
                    $letter->send();
                }

                // шлем ему SMS
                if ($x->getPhone()) {
                    // @todo
                }
            }
        }
    }

}