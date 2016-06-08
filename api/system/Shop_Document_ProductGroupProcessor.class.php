<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class Shop_Document_ProductGroupProcessor {

    public function process($assigns) {
        $productsArray = $assigns['productsArray'];
        $a = array();

        foreach ($productsArray as $product) {
            $name = $product['name'];

            $nameParts = explode(' / ', $name);
            if (count($nameParts) == 5) {
                unset($nameParts[3]);
                unset($nameParts[4]);
                $name = implode(' / ', $nameParts);
            }

            if (isset($a[$name]) && $a[$name]['price'] == $product['price'] ) {

                $a[$name]['count'] = number_format(($a[$name]['count'] + $product['count']), 3);
                $a[$name]['sum'] = number_format($a[$name]['sum'] + $product['sum'], 2);
                $a[$name]['sumnotax'] = number_format($a[$name]['sumnotax'] + $product['sumnotax'], 2);

            } else {

                $a[$name] = $product;
                $a[$name]['name'] = $name;

            }
        }

        $assigns['productsArray'] = $a;
        return $assigns;
    }

}