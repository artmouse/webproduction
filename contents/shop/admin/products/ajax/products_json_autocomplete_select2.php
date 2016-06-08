<?php
class products_json_autocomplete_select2 extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgumentSecure('name');
            $add = $this->getArgumentSecure('add');

            $cuser = $this->getUser();

            $a = array();
            // поиск продуктов
            $products = Shop::Get()->getShopService()->searchProducts($query, false);
            $products->setLimitCount(200);
            while ($x = $products->getNext()) {
                $b = array();

                $b['id'] = $x->getId();
                $b['name'] = $x->makeName(false);
                $b['price'] = $x->getPrice();

                try {
                    $b['currency'] = $x->getCurrency()->getSymbol();
                } catch (ServiceUtils_Exception $se) {

                }

                $b['avail'] = $x->getAvail();

                $a[] = $b;
            }

            // купоны
            $query = strtoupper($query);
            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->setLimitCount(4);
            $products->setDeleted(0);

            $products->addWhere('linkkey', '%'.$query.'%', 'LIKE');

            while ($x = $products->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(false).' ('.$x->getLinkkey().')'
                );
            }

            if ($add != 'no') {
                $a[] = array(
                'id' => 0,
                'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_dobavit_').$query
                );
            }

            // выдача результатов
            echo json_encode($a);
            exit;
        } catch (Exception $e) {
            throw $e;
        }

    }

}