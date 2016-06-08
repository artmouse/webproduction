<?php
class storage_order_table_block extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();
            $order = StorageOrderService::Get()->getStorageOrderByID(
            $this->getValue('orderid')
            );

            // валюта по умолчанию
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

            // товары заказа
            $orderproducts = $order->getStorageOrderProducts();

            $orderArray = array();
            while ($orderproduct = $orderproducts->getNext()) {
                try {
                    $currencySymbol = '';
                    try {
                        $currencySymbol = $orderproduct->getCurrency()->getSymbol();
                    } catch (ServiceUtils_Exception $se) {
                        
                    }

                    $product = $orderproduct->getProduct();

                    $orderArray[] = array(
                    'id' => $orderproduct->getId(),
                    'price' => $orderproduct->getPrice(),
                    'currencyid' => $orderproduct->getCurrencyid(),
                    'currency' => $currencySymbol,
                    'count' => $orderproduct->getAmount(),
                    'name' => $product->getName(),
                    'productid' => $product->getId(),
                    'unit' => $product->getUnit(),
                    'editable' => !$orderproduct->getIsshipped()
                    );

                    // считаем сумму с конвертацией
                    // определяем цену pricebase - это цена в системной валюте
                    // с учетом НДС (необходима для построения баланса)
                    try {
                        $money = new ShopMoney(
                        $orderproduct->getPrice() * $orderproduct->getAmount(),
                        $orderproduct->getCurrency(),
                        0
                        );

                        $price = $money->getAmount();
                        $priceBase = $money->changeCurrency($currencyDefault)->getAmount();

                        $this->_productSum += $priceBase;
                    } catch (ServiceUtils_Exception $se) {

                    }
                } catch (Exception $e) {

                }
            }

            // массив товаров в корзине прихода
            $this->setValue('orderArray', $orderArray);
            $this->setValue('isIncoming', ($order->getType() == 'incoming'));

            $this->setValue('orderid', $order->getId());
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
