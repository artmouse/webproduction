<?php
class storage_sale_table_block extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            // валюта по умолчанию
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

            // корзина накладной
            $sales = StorageSaleService::Get()->getSalesByUser($cuser, true);

            $saleArray = array();
            while ($sale = $sales->getNext()) {
                try {
                    $product = $sale->getProduct();

                    $saleArray[] = array(
                    'id' => $sale->getId(),
                    'price' => $sale->getPrice(),
                    'currencyid' => $sale->getCurrencyid(),
                    'currency' => $sale->getCurrency()->getSymbol(),
                    'count' => $sale->getAmount(),
                    'name' => $product->getName(),
                    'productid' => $product->getId(),
                    'unit' => $product->getUnit(),
                    'linkedAmount' => StorageLinkService::Get()->getLinkedProductAmount($cuser, $sale)
                    );

                    // считаем сумму с конвертацией
                    // определяем цену pricebase - это цена в системной валюте
                    // с учетом НДС
                    $money = new ShopMoney(
                    $sale->getPrice() * $sale->getAmount(),
                    $sale->getCurrency(),
                    0
                    );
                    $price = $money->getAmount();
                    $priceBase = $money->changeCurrency($currencyDefault)->getAmount();

                    $this->_productSum += $priceBase;
                } catch (Exception $e) {

                }
            }

            // массив товаров в корзине прихода
            $this->setValue('saleArray', $saleArray);
            $this->setValue('sum', number_format($this->_productSum, 2));
            $this->setValue('currency', $currencyDefault->getSymbol());

            // валюты
            $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
            $this->setValue('currencyArray', $currency->toArray());
        } catch (Exception $ge) {

        }
    }

    private $_productSum = 0;

}