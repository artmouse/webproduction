<?php
/**
 * ShopOrderProduct_Status_SupplierOrder
 * 
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * 
 * @copyright WebProduction
 * 
 * @package OneBox
 */
class ShopOrderProduct_Status_SupplierOrder {

    public function process(ShopOrderProduct $orderProduct, $paramArray) {
        $statusID = $paramArray['status'];
        $workflowID = $paramArray['workflow'];

        // в этом статусе продукт должен быть в заказе поставщику
        // статус заказа не имеет значения

        $tmp = new ShopOrderProduct();
        $tmp->setProductid($orderProduct->getProductid());
        $tmp->setLinkkey('orderproduct-'.$orderProduct->getId());
        if ($tmp->select()) {
            // связанный товар найден.
            // обновляем количество

            $tmp->setProductcount($orderProduct->getProductcount());
            $tmp->update();

            // пересчитать цены
            Shop::Get()->getShopService()->recalculateOrderSums($tmp->getOrder());
        } else {
            // связанный товар не найден.

            // определяем поставщика
            $supplier = $orderProduct->getSupplier();
            $supplierContact = $supplier->getContact();

            // находим открытый заказ поставщику
            $orderSupplier = new ShopOrder();
            $orderSupplier->setOutcoming(1);
            $orderSupplier->setUserid($supplierContact->getId());
            $orderSupplier->setStatusid($statusID);
            $orderSupplier->setCategoryid($workflowID);
            if ($orderSupplier->select()) {
                // открытый заказ найден,

                // дописываем в него
                $this->_addOrderProduct($orderSupplier, $orderProduct);

            } else {
                // заказ не найден
                // нужно создавать новый

                $orderSupplier = Shop::Get()->getShopService()->makeOrderEmpty();
                $orderSupplier->setUserid($supplierContact->getId());
                $orderSupplier->setStatusid($statusID);
                $orderSupplier->setCategoryid($workflowID);
                $orderSupplier->setOutcoming(1);
                $orderSupplier->update();

                // дописываем в него
                $this->_addOrderProduct($orderSupplier, $orderProduct);
            }

        }
    }

    private function _addOrderProduct(ShopOrder $orderSupplier, ShopOrderProduct $orderProduct) {
        // определяем цену и поставщика
        try {
            $supplierPrice = 0;
            $supplierCode = '';
            $supplierCurrencyID = Shop::Get()->getCurrencyService()->getCurrencySystem()->getId();

            $product = $orderProduct->getProduct();

            $productSupplier = Shop::Get()->getSupplierService()->getProductSupplierFromProduct(
                $product
            );
            
            while ($x = $productSupplier->getNext()) {
                $supplierID = $x->getSupplierid();
                if ($supplierID == $orderProduct->getSupplierid()) {
                    $supplierPrice = $x->getPrice();
                    $supplierCurrencyID = $x->getCurrencyid();
                    $supplierCode = $x->getCode();
                    break;
                }
            }

        } catch (Exception $e) {

        }

        $tmp = new ShopOrderProduct();
        $tmp->setProductid($orderProduct->getProductid());
        $tmp->setOrderid($orderSupplier->getId());
        $tmp->setProductname($supplierCode.' '.$orderProduct->getProductname());
        $tmp->setProductcount($orderProduct->getProductcount());
        $tmp->setProductprice($supplierPrice);
        $tmp->setCurrencyid($supplierCurrencyID);
        $tmp->setLinkkey('orderproduct-'.$orderProduct->getId());
        $tmp->insert();

        // пересчитать цены
        Shop::Get()->getShopService()->recalculateOrderSums($orderSupplier);
    }

}