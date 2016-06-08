<?php
class source_autocomplete extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgumentSecure('name');

            $source = Shop::Get()->getShopService()->getSourceAll();
            $source->addWhere('address', '%'.$query.'%', 'LIKE');
            $a = array();
            while ($x = $source->getNext()) {
                $a[] = array(
                    'name' => $x->getName(),
                    'value' => $x->getAddress(),
                );
            }

            echo json_encode($a);
        } catch (Exception $e) {

        }

        exit();
    }

}