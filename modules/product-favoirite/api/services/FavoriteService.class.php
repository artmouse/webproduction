<?php

class FavoriteService extends ServiceUtils_AbstractService {

    /**
     * @param ShopProduct $product
     * @param User $user
     * @return bool
     */
    public function isProductFavorite(ShopProduct $product,User $user) {
        $x = new XShopUserProductsFavorite();
        $x->setUserid($user->getId());
        $x->setProductid($product->getId());
        return $x->select();
    }

    /**
     * @param User $user
     * @return XShopUserProductsFavorite
     */
    public function getFavoriteProductsByUser(User $user) {
        $x = new XShopUserProductsFavorite();
        $x->setUserid($user->getId());
        return $x;
    }

    public function isProductFavoriteExist() {
        try {
            $user = Shop::Get()->getUserService()->getUser();
            $x = new XShopUserProductsFavorite();
            $x->setUserid($user->getId());
            return $x->select();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @return FavoriteService
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __construct() {

    }

    private function __clone() {

    }

    private static $_Instance = null;

}