<?php

class Shop_Processor_UpdateProductGrouped {

    public function process() {
        // пересчет группированых товароы
        Shop::Get()->getShopService()->updateProductGrouped();
    }

}