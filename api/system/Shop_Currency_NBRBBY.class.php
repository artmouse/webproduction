<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class Shop_Currency_NBRBBY {

    public function process(ShopCurrency $currency) {
        $url = 'http://www.nbrb.by/Services/XmlExRates.aspx';
        $urlp = parse_url($url);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $xml = curl_exec($curl);
        curl_close($curl);

        $exchangerates = new SimpleXMLElement($xml);
        foreach ($exchangerates->Currency as $row) {
            $val = $row->CharCode.'';
            $sale = $row->Rate.'';
            if ($currency->getName() == $val && $sale > 0) {
                return $sale;
            }
        }

        return false;
    }

}