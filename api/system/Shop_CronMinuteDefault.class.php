<?php
/**
 * Минутный обработчик
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   OneBox
 */
class Shop_CronMinuteDefault implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        // xls
        ModeService::Get()->verbose('Export XLS products...');
        Shop::Get()->getShopService()->exportTaskXLS();
        ModeService::Get()->verbose('Import XLS products...');
        Shop::Get()->getShopService()->importTaskXLS();

        ModeService::Get()->verbose('Export XLS orders...');
        Shop::Get()->getShopService()->importTaskOrderXLS();

        ModeService::Get()->verbose('Export XLS contacts...');
        Shop::Get()->getShopService()->exportContactsTaskXLS();
        ModeService::Get()->verbose('Import XLS contacts...');
        Shop::Get()->getShopService()->importContactsTaskXLS();

        ModeService::Get()->verbose('Export XLS massive task...');
        Shop::Get()->getShopService()->exportMassiveTaskXLS();
        ModeService::Get()->verbose('Import XLS massive task...');
        Shop::Get()->getShopService()->importMassiveTaskXLS();

        // email
        ModeService::Get()->verbose('Process mail que...');
        $sender = Engine::Get()->getConfigFieldSecure('mail-sender');
        if (!is_object($sender)) {
            $sender = new $sender();
        }
        MailUtils_Config::Get()->setSender($sender);
        MailUtils_SenderQueDB::ProcessQue();

        // sms
        ModeService::Get()->verbose('Process SMS que...');
        $apiLogin = Shop::Get()->getSettingsService()->getSettingValue('sms-login');
        $apiPassword = Shop::Get()->getSettingsService()->getSettingValue('sms-password');
        if ($apiLogin && $apiPassword) {

            $senderMethod = Shop::Get()->getSettingsService()->getSettingValue('sms-service-sms-send');

            if ($senderMethod == 'TurboSMS') {
                SMSUtils_SenderQueDB::ProcessQue(
                    new SMSUtils_SenderTurbosmsua($apiLogin, $apiPassword)
                );

            }
            if ($senderMethod == 'SMSCru') {
                SMSUtils_SenderQueDB::ProcessQue(
                    new SMSUtils_SenderSMSCru($apiLogin, $apiPassword)
                );
            }
            if ($senderMethod == 'SMSCkz') {
                SMSUtils_SenderQueDB::ProcessQue(
                    new SMSUtils_SenderSMSCkz($apiLogin, $apiPassword)
                );
            }
        }

        // создаем поставщиков по outcoming заказам автоматически
        Shop::Get()->getSupplierService()->syncSuppliers();

        // очередь отложенных процессоров
        ProcessorQueService::Get()->processQue();
    }

}