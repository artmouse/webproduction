<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class Shop_Currency_BankUA {
    /**
     * @param ShopCurrency $currency
     * @return mixed
     */
    public function process(ShopCurrency $currency) {
        $xml = @simplexml_load_string(file_get_contents('http://bank-ua.com/export/currrate.xml'));

        $result = false;
        foreach ($xml->item as $item) {
            // записываем в кеш
            $tmp = ($item->rate.'') / ($item->size.'');

            if ($item->char3.'' == $currency->getName()) {
                $result = $tmp;
            }
        }

        $result = str_replace(',', '.', $result);
        return $result;
    }

}