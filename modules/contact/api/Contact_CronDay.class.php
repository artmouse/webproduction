<?php
/**
 * Contact cron daily
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   OneBox
 */
class Contact_CronDay implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        // на все группы делаем до поля автоматически
        $this->_fieldSystemFix();
    }

    private function _fieldSystemFix() {
        ModeService::Get()->verbose('fix contact system fields...');

        $systemArray = array();
        $systemArray['customphone'] = 'Телефоны';
        $systemArray['customemail'] = 'Email';
        $systemArray['customskype'] = 'Skype';
        $systemArray['customjabber'] = 'Jabber';
        $systemArray['customwhatsapp'] = 'Whatsapp';
        $systemArray['customaddress'] = 'Адрес';
        $systemArray['customsource'] = 'Источник';
        $systemArray['customcontractor'] = 'Юридическое лицо';
        $systemArray['custombdate'] = 'Дата рождения';
        $systemArray['customurl'] = 'Сайты и ссылки';
        $systemArray['customparent'] = 'По рекомендации';
        $systemArray['customreferral'] = 'Начисление реферальных';
        $systemArray['customlinks'] = 'Связи';
        $systemArray['customtags'] = 'Теги';
        $systemArray['custompricelevel'] = 'Уровень цен';
        $systemArray['customsubscribe'] = 'Подписка';

        $groups = Shop::Get()->getUserService()->getUserGroupsAll();
        while ($group = $groups->getNext()) {

            foreach ($systemArray as $key => $name) {
                $field = new XShopContactField();
                $field->setGroupid($group->getId());
                $field->setIdkey($key);
                if (!$field->select()) {
                    $field = new XShopContactField();
                    $field->setGroupid($group->getId());
                    $field->setName($name);
                    if (!$field->select()) {
                        $field->setType('system');
                        $field->setIdkey($key);
                        $field->insert();
                    }

                }
            }
        }
    }

}