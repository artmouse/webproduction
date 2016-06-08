<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class ShopOrderProduct_Status_SupplierOrderDone {

    public function process() {
        // в этом статусе продукт должен быть в заказе поставщику
        // статус заказа не имеет значения

        // в этот статус система переключает сама, когда
        // товар приехал (оприходован) и заказ поставщику закрыт
    }

}