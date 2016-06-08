<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Package
 */
class Shop_Currency_PrivatBankUA {

    public function process(ShopCurrency $currency) {
        $url = 'https://api.privatbank.ua/p24api/pubinfo?exchange&coursid=5';
        $urlp = parse_url($url);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $xml = curl_exec($curl);
        curl_close($curl);

        $exchangerates = new SimpleXMLElement($xml);
        foreach ($exchangerates->row as $row) {
            $val = $row->exchangerate['ccy'];
            $sale = $row->exchangerate['sale'];
            if ($currency->getName() == $val && $sale > 0) {
                return $sale;
            }
        }

        return false;
    }

}