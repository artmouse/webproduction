<?php
class add_new_category_ajax extends Engine_Class {

    public function process() {

        $name = $this->getArgumentSecure('name');
        $parentID = $this->getArgumentSecure('parentID');

        if ($name) {

            try {
                $category = Shop::Get()->getShopService()->addCategory($name, $parentID);
                echo json_encode('ok');
            } catch (Exception $e) {
                echo json_encode('error');
            }
        }
        exit;
    }

}