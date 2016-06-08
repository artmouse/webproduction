<?php
class product_search extends Engine_Class {

    public function process() {
        $a = array();
        $status = false;
        $errorsArray = array();

        try {
            $query = $this->getArgumentSecure('query');

            if ($query) {
                try{
                    if ( is_numeric($query)) {
                        $category =  Shop::Get()->getShopService()->getCategoryAll();
                        $category->setId( $query );
                        $category = $category->getNext();

                        if (!$category) {
                            throw new Exception('');
                        }

                        $products = Shop::Get()->getShopService()->getProductsByCategory($category);

                        $products->setLimitCount(50);
                    }else{
                        $products = Shop::Get()->getShopService()->searchProducts($query, false);
                        $products->setLimitCount(50);
                    }
                }catch (Exception $e){
                    $products = Shop::Get()->getShopService()->searchProducts($query, false);
                    $products->setLimitCount(50);
                }
            } else {
                $products = Shop::Get()->getShopService()->getProductsAll();
                $products->setDeleted(0);
                $products->setLimitCount(50);
            }
            while ($x = $products->getNext()) {
                try {
                    $currencyName = $x->getCurrency()->getSymbol();
                } catch (Exception $cEx) {
                    $currencyName = '';
                }
                $image = false;
                if ($x->getImage()) {
                    $image = $x->makeImageThumb('250','200');
                }

                $a[] = array(
                    'id' => $x->getId(),
                    'name' => htmlspecialchars($x->getName()),
                    'price' => $x->getPrice(),
                    'currencyname' => $currencyName,
                    'image' => $image
                );
            }
            $status = 'success';
        } catch (Exception $e) {
            $status = 'error';
            $errorsArray = array();
        }

        $json = array(
            'status' => $status,
            'result' => $a,
            'errors' => $errorsArray
        );

        echo json_encode($json);
        exit();
    }

}