<?php

class ajax_supplier_binding_products extends Engine_Class {
    public function process() {
        try {
            $droponId = $this->getArgumentSecure('dropOnId');
            $movedId = $this->getArgumentSecure('movedId');
            // Проставить новый продукт в загрузку
            // @todo на методы все
            $tmp = new XShopTmpPrice();
            $tmp->filterId($droponId);
            if ($tmp->select()) {
                $tmp->setProductid($movedId);
                $tmp->setIsnew(0);
                $tmp->setMatchreason('Ручной выбор');
                $tmp->update();
            } else {
                throw new Exception();
            }
            // Запомнить выбор пользователя
            $userSelection = new XShopPriceSupplierUserSelection();
            $userSelection->setName($tmp->getName());
            if ($userSelection->select()) {
                $userSelection->setProductid($movedId);
                $userSelection->update();
            } else {
                $userSelection->setProductid($movedId);
                $userSelection->insert();
            }

            $product = Shop::Get()->getShopService()->getProductByID($movedId);
            // отмечаем что товар был в прайсе
            $product->setSync(0);
            $product->update();
            $infoArray = $product->makeInfoArray();
            $infoArray['url'] = $product->makeURLEdit();

            echo json_encode($infoArray);
            exit();
        } catch(Exception $e) {
            echo json_encode(array('error'));
            exit();
        }

        // данные по новому про
    }
}