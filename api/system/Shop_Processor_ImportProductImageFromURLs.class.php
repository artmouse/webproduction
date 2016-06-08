<?php

class Shop_Processor_ImportProductImageFromURLs {

    public function process() {
        // вытягивание картинок из tmpimageurl
        Shop::Get()->getShopService()->importProductImageFromURLs();
    }

}