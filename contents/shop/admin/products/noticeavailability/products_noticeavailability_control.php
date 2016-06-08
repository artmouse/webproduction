<?php
class products_noticeavailability_control extends Engine_Class {

    public function process() {
        try {
            $ID = $this->getArgumentSecure('id');
            $x = Shop::Get()->getProductsNoticeOfAvailabilityService()->getProductsNoticeOfAvailabilityID($ID);
            // Если есть такая запись в базе, то устанавливаем контрольные значения
            if ($x->getId()) {
                $this->setControlValue("control_id", $x->getId());
                $this->setControlValue("name", $x->getName());
                $this->setControlValue("email", $x->getEmail());
                $this->setControlValue("status", $x->getStatus());
                $this->setControlValue("cdate", $x->getCdate());
                $this->setControlValue("senddate", $x->getSenddate());
                $this->setControlValue("productid", $x->getProductid());
            }
            // Если человек нажал "Сохранить"
            if ($this->getArgumentSecure("formsUpdate")) {
                try {
                    Shop::Get()->getProductsNoticeOfAvailabilityService()->updateProductsNoticeOfAvailability(
                        $x,
                        $this->getArgumentSecure("name"),
                        $this->getArgumentSecure("email"),
                        $this->getArgumentSecure("status"),
                        $this->getArgumentSecure("cdate"),
                        $this->getArgumentSecure("senddate"),
                        $this->getArgumentSecure("productid")
                    );
                }
                catch(Exception $eupdate) {
                    throw $eupdate;
                }
            }
            if ($this->getArgumentSecure("formsDelete")) {
                if (Shop::Get()->getProductsNoticeOfAvailabilityService()->deleteProductsNoticeOfAvailability($x)) {
                    header("location: /admin/shop/products/noticeavailability/");
                }
            }
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}