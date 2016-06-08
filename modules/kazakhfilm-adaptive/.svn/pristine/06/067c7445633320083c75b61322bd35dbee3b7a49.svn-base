<?php
class currency_index extends Engine_Class {

    public function process() {
        if ($this->getArgumentSecure('ok')){
            try {
                SQLObject::TransactionStart();
                $symbolArray = $this->getArgumentSecure('symbol');
                $defaultArray = $this->getArgumentSecure('default');
                $currencyArray = $this->getArgumentSecure('currency');
                $deleteArray = $this->getArgumentSecure('delete');
                $hiddenArray = $this->getArgumentSecure('hidden');
                $sortArray = $this->getArgumentSecure('sort');
                $autoupdateArray = $this->getArgumentSecure('autoupdate');

                if ($currencyArray) {
                    foreach ($currencyArray as $id=>$rate){
                        $select = false;

                        if ($defaultArray[0] == $id) {
                            $default = 1;
                        } else {
                            $default = 0;
                        }
                        /*Shop::Get()->getCurrencyService()->updateCurrency(
                            $id,
                            $rate,
                            $symbolArray[$id],
                            @$hiddenArray[$id],
                            @$autoupdateArray[$id],
                            @$sortArray[$id]
                        );*/
                        Kazakh::Get()->getKazakhService()->updateCurrency(
                            $id,
                            $rate,
                            $symbolArray[$id],
                            $default,
                            @$hiddenArray[$id],
                            @$autoupdateArray[$id],
                            @$sortArray[$id]
                        );
                    }
                }

                if ($deleteArray) {
                    foreach ($deleteArray as $deleteID) {
                        Shop::Get()->getCurrencyService()->deleteCurrency($deleteID);
                    }
                }

                $this->setValue('message','ok');

                SQLObject::TransactionCommit();
            } catch(Exception $ge) {
                SQLObject::TransactionRollback();
                $this->setValue('message', 'error');
            }
        }

        $currency1 = Shop::Get()->getCurrencyService()->getCurrencyAll();
        $currency1->setOrder('name', 'DESC');
        $a = array();
        while($c = $currency1->getNext()){
            $delete = !Shop::Get()->getCurrencyService()->checkCurrencyUse($c);

            $a[] = array(
                'id' => $c->getId(),
                'rate' => $c->getRate(),
                'name' => $c->getName(),
                'default' => $c->getDefault(),
                'symbol' => $c->getSymbol(),
                'hidden' => $c->getHidden(),
                'sort' => $c->getSort(),
                'autoupdate' => $c->getAutoupdate(),
                'delete' => $delete
            );
        }

        $this->setValue('currencyArray', $a);
    }

}