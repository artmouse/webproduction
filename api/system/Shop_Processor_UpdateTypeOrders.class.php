<?php

class Shop_Processor_UpdateTypeOrders {

    public function process() {
        Shop::Get()->getShopService()->updateTypeOrders();
    }

}