<?php
class storage_basket_block_table extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            // валюта по умолчанию
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

            // корзина
            $baskets = StorageBasketService::Get()->getStorageBasketsByUser(
            $cuser,
            $this->getValue('type')
            );

            $productSum = 0;

            $basketArray = array();
            while ($basket = $baskets->getNext()) {
                try {
                    $product = $basket->getProduct();

                    $basketArray[] = array(
                    'id' => $basket->getId(),
                    'serial' => $basket->getSerial(),
                    'price' => $basket->getPrice(),
                    'currencyid' => $basket->getCurrencyid(),
                    'currency' => $basket->getCurrency()->getSymbol(),
                    'tax' => $basket->getTax(),
                    'count' => $basket->getAmount(),
                    'name' => $product->getName(),
                    'productid' => $product->getId(),
                    'unit' => $product->getUnit(),
                    'shipment' => $basket->getShipment(),
                    'warranty' => $basket->getWarranty(),
                    'linkedAmount' => StorageLinkService::Get()->getLinkedProductAmount($cuser, $basket)
                    );

                    // считаем сумму с конвертацией
                    // определяем цену pricebase - это цена в системной валюте
                    // с учетом НДС (необходима для построения баланса)
                    $money = new ShopMoney(
                    $basket->getPrice() * $basket->getAmount(),
                    $basket->getCurrency(),
                    0
                    );
                    $price = $money->getAmount();
                    $priceBase = $money->changeCurrency($currencyDefault)->getAmount();

                    $productSum += $priceBase;
                } catch (Exception $e) {

                }
            }

            // массив товаров в корзине прихода
            $this->setValue('basketArray', $basketArray);
            $this->setValue('sum', number_format($productSum, 2));
            $this->setValue('currency', $currencyDefault->getSymbol());

            // валюты
            $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
            $this->setValue('currencyArray', $currency->toArray());
        } catch (Exception $ge) {

        }
    }

}