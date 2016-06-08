<?php
class novaposhta_get_offices_ajax extends Engine_Class {

    public function process() {
        $city = $this->getArgumentSecure('city');

        echo json_encode(Shop::Get()->getNovaPoshtaApiService()->getOfficesByCity($city));

        exit;
    }

}