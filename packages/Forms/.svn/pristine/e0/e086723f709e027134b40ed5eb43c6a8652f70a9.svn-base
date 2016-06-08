<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @author Oleksii Golub <avator@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ValidatorDecimal extends Forms_AValidator {

    public function validate($data) {
        $aLocaleConv = localeconv();
        return preg_match('/^\d+(\\'.$aLocaleConv['decimal_point'].'\d+)?$/', $data);
    }

}