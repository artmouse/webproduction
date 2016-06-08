<?php
class shop_search_company_autocomplete extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgumentSecure('name');

            $companies = Shop::Get()->getShopService()->searchCompany($query);

            echo json_encode($companies);
        } catch (Exception $e) {

        }
    }

}