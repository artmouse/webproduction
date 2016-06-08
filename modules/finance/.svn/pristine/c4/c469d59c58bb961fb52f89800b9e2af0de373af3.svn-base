<?php
/**
 * OneBox
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class FinanceCategory extends XFinanceCategory {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return FinanceCategory
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return FinancePayment
     */
    public static function Get($key) {
        return self::GetObject('FinanceCategory', $key);
    }

    /**
     * Это фонд?
     *
     * @return bool
     */
    public function isFund() {
        if ($this->getFundpercent() > 0 || $this->getFundsum() > 0 || $this->getIsfund()) {
            return true;
        }
    }

}