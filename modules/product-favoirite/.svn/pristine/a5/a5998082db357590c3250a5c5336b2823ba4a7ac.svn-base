<?php
class client_shop_favorite extends Engine_Class {

    public function process() {
        try {
            $user = $this->getUser();
            $productsFavorite = FavoriteService::Get()->getFavoriteProductsByUser($user);

            $a = array(0);
            while ($op = $productsFavorite->getNext()) {
                $a[] = $op->getProductid();
            }
            $a = array_unique($a);

            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->addWhereArray($a);

            $render = Engine::GetContentDriver()->getContent('shop-product-list');
            $render->setValue('items', $products);
            $this->setValue('products', $render->render());

            $render = Engine::GetContentDriver()->getContent('shop-client-tpl');
            $render->setValue('selected','product-favorite');
        } catch (Exception $ge) {
            if (method_exists($ge, 'log')) {
                $ge->log();
            }
            print $ge;
            Engine::Get()->getRequest()->setContentNotFound();

            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }
        }
    }

}