<?php
/**
 * Box_CronMinute
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 *
 * @copyright WebProduction
 *
 * @package OneBox
 */
class Box_CronMinute implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        // парсер звонков
        try {
            EventService::Get()->processCallCDR();
        } catch (Exception $e) {
            print $e;
        }

        $this->_checkKey();
    }

    /**
     * Удалить сессии всех юзеров,
     * которые превышают количество лицензий OneBox
     */
    private function _checkKey() {
        ModeService::Get()->verbose('Check license key...');

        $file = MEDIA_PATH.'/tmp/key';
        if (!file_exists($file)) {
            return false;
        }

        $result = (int) file_get_contents($file);

        try {
            SQLObject::TransactionStart(false, true);

            $auth = new XUserAuth();
            $auth->setOrder('adate', 'ASC');

            $k = 0;
            while ($x = $auth->getNext()) {
                $k++;

                if ($k > $result) {
                    $x->delete();
                }
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            print $ge;
        }
    }

}