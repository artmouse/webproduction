<?php
class ajax_favorite_check extends Engine_Class {

    public function process() {
        try {
            $productIdArray = explode(',',$this->getArgument('productid_str'));
            if (!$productIdArray) {
                throw new Exception('');
            }

            $isFavoriteText = Engine::Get()->getConfigFieldSecure('isFavoriteText');
            $inFavoriteText = Engine::Get()->getConfigFieldSecure('inFavoriteText');

            $productIdArray = array_unique($productIdArray);
            $a = array();
            // желаемые товары только для авторизованных
            try {
                $user = $this->getUser();
                foreach ($productIdArray as $productId) {
                    try {
                        $product = Shop::Get()->getShopService()->getProductByID($productId);
                        if (FavoriteService::Get()->isProductFavorite($product,$user)) {
                            $a[] = array(
                                'id' => $productId,
                                'name' => $isFavoriteText, // 'В избранном',
                                'element_class' => 'favorite',
                                'auth' => '1',
                            );
                        } else {
                            $a[] = array(
                                'id' => $productId,
                                'name' => $inFavoriteText, // 'В избранное',
                                'element_class' => '',
                                'auth' => '1'
                            );
                        }
                    } catch (Exception $e) {

                    }
                }
            } catch (Exception $ee) {
                foreach ($productIdArray as $productId) {
                    $a[] = array(
                        'id' => $productId,
                        'name' => $inFavoriteText, // 'В избранное',
                        'element_class' => '',
                        'auth' => ''
                    );
                }
            }

            echo  json_encode($a);
            exit();
        } catch (Exception $e) {

        }
    }

}