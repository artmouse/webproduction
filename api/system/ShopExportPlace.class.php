<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopExportPlace extends XShopExportPlace {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopExportPlace
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * Построить ссылку на скачивание прайс-площадки
     *
     * @return string
     */
    public function makeExternalLink() {
        return Engine::Get()->getProjectURL().'/media/export/'.$this->getId().'.xml';
    }

}