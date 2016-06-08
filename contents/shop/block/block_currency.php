<?php
class block_currency extends Engine_Class {

    public function process() {
        // Валюты
        try {
            $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
            $currency->setHidden(0);

            $a = array();
            while ($x = $currency->getNext()) {
                if ( $x->getRate() == 1 ){ // пропускаем гривну
                    continue;
                }
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    'symbol' => $x->getSymbol(),
                    'rate' => $x->getRate(),
                );
            }
            $this->setValue('currencyArray', $a);

        } catch(Exception $e) {

        }
    }

}