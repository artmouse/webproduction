<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class ShopOrderProduct_Status_SupplierOrderAccept {

    public function process($paramArray) {
        $orderStatusID = $paramArray['orderstatus'];
        $productStatusID = $paramArray['productstatus'];

        // все заказы поставщика в статусе orderstatus
        $orders = Shop::Get()->getShopService()->getOrdersAll();
        $orders->setOutcoming(1);
        $orders->setStatusid($orderStatusID);
        while ($order = $orders->getNext()) {
        	$ops = $order->getOrderProducts();
        	while ($x = $ops->getNext()) {
                if (preg_match("/^orderproduct-(\d+)$/ius", $x->getLinkkey(), $r)) {
                	try {
                	    $linkedOrderProduct = Shop::Get()->getShopService()->getOrderProductById($r[1]);
                	    $linkedOrderProduct->setStatusid($productStatusID);
                	    $linkedOrderProduct->update();

                	    // @todo: если все товары этого заказа прибыли
                	    // то переключаем статус заказа в Готов к отправке
                	    //$linkedOrder = $linkedOrderProduct->getOrder();
                	} catch (Exception $e) {

                	}
                }
        	}
        }
    }

}