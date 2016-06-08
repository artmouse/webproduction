<?php
class ajax_favorite_toggle extends Engine_Class {

    public function process() {
        try {
            $productid = $this->getArgument('productid');
            $user = $this->getUser();

            $isFavoriteText = Engine::Get()->getConfigFieldSecure('isFavoriteText');
            $inFavoriteText = Engine::Get()->getConfigFieldSecure('inFavoriteText');

            $x = new XShopUserProductsFavorite();
            $x->setProductid($productid);
            $x->setUserid($user->getId());
            if ($x->select()) {
                $x->delete();
                $a = array(
                    'id' => $productid,
                    'name' => $inFavoriteText// 'В избранное',
                );
            } else {
                $x->insert();
                $a = array(
                    'id' => $productid,
                    'name' => $isFavoriteText// 'В избранном',
                );
            }
            echo  json_encode($a);
            exit();
        } catch (Exception $e) {

        }
    }

}