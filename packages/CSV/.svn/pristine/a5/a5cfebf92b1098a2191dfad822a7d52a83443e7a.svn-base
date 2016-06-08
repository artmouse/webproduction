<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package CSV
 */
class CSV_Exception extends Exception {

    public function __construct($message = '', $code = 0) {
        parent::__construct($message, $code);
    }

    public function __toString() {
        if (class_exists('DebugException')) {
            return DebugException::Display($this, __CLASS__);
        }

        return parent::__toString();
    }

}