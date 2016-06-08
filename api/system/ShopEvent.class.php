<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class ShopEvent extends XShopEvent {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * Получить следующий объект
     *
     * @return ShopEvent
     */
    public function getNext($exception = false) {
        1;
        return parent::getNext($exception);
    }

    /**
     * Получить объект по ключу
     *
     * @return ShopEvent
     */
    public static function Get($key) {
        return self::GetObject('ShopEvent', $key);
    }

    /**
     * Построить имя события
     *
     * @return string
     */
    public function makeName() {
        $subject = trim($this->getSubject());

        if (!$subject) {
            if ($this->getType() == 'call') {
                $subject = 'Call from '.$this->getFrom().' to '.$this->getTo();
            } elseif ($this->getType() == 'email') {
                $subject = 'Email from '.$this->getFrom().' to '.$this->getTo();
            } else {
                $subject = 'Unamed event '.$this->getType();
            }
        }

        return htmlspecialchars($subject);
    }

    public function makeDirection() {
        if ($this->getDirection() == 0) {
            return 'Our';
        } elseif ($this->getDirection() < 0) {
            return 'In';
        } else {
            return 'Out';
        }
    }

    /**
     * Получить контакт from
     *
     * @return User
     */
    public function getFromContact() {
        return Shop::Get()->getUserService()->getUserByID(
            $this->getFromuserid()
        );
    }

    /**
     * Получить контакт to
     *
     * @return User
     */
    public function getToContact() {
        return Shop::Get()->getUserService()->getUserByID(
            $this->getTouserid()
        );
    }

    /**
     * Получить ссылку на карточку встречи
     *
     * @return Url
     */
    public function makeURL() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
            'event-view',
            $this->getId()
        );
    }

    /**
     * Получить файлы вложения в событие (письмо)
     *
     * @return ShopFile
     */
    public function getAttachmentFiles() {
        return Shop::Get()->getFileService()->getFilesByLinkkey(
            'event-'.$this->getId()
        );
    }

    /**
     * Получить массив ID вложенных ShopFile
     *
     * @return array
     */
    public function getAttachmentFileIDArray() {
        $a = array();
        $files = $this->getAttachmentFiles();
        while ($x = $files->getNext()) {
            $a[] = $x->getId();
        }
        return $a;
    }

}