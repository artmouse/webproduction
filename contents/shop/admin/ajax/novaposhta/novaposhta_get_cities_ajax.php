<?php
class novaposhta_get_cities_ajax extends Engine_Class {

    public function process() {
        echo json_encode(Shop::Get()->getNovaPoshtaApiService()->getCityAll());
        exit;
    }

}