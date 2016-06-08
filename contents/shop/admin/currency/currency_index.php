<?php
class currency_index extends Engine_Class {

    public function process() {
        if ($this->getArgumentSecure('ok')){
            try {
                SQLObject::TransactionStart();

                $symbolArray = $this->getArgumentSecure('symbol');
                $currencyArray = $this->getArgumentSecure('currency');
                $deleteArray = $this->getArgumentSecure('delete');
                $hiddenArray = $this->getArgumentSecure('hidden');
                $sortArray = $this->getArgumentSecure('sort');
                $autoupdateArray = $this->getArgumentSecure('autoupdate');
                $percentArray = $this->getArgumentSecure('percent');

                if ($currencyArray) {
                    foreach ($currencyArray as $id=>$rate){
                        $select = false;

                        Shop::Get()->getCurrencyService()->updateCurrency(
                        $id,
                        $rate,
                        $symbolArray[$id],
                        @$hiddenArray[$id],
                        @$autoupdateArray[$id],
                        @$percentArray[$id],
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
        $currency1->setOrder('sort', 'ASC');
        $a = array();
        while ($c = $currency1->getNext()){
            $delete = !Shop::Get()->getCurrencyService()->checkCurrencyUse($c);

            $a[] = array(
            'id' => $c->getId(),
            'rate' => $c->getRate(),
            'name' => $c->getName(),
            'default' => $c->getDefault(),
            'symbol' => $c->getSymbol(),
            'hidden' => $c->getHidden(),
            'sort' => $c->getSort(),
            'autoupdate' => $c->getLogicclass(),
            'percent' => $c->getPercent(),
            'delete' => $delete,
            );
        }

        $this->setValue('currencyArray', $a);
    }

}