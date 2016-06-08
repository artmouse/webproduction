<?php
class shop_product_set extends Engine_Class {

    public function process() {
        try {
            $list = Shop::Get()->getShopService()->getProductsListByID($this->getArgument('id'));
            if ($list->getHidden() || $list->getShowtype() != 'set') {
                throw new Exception('');
            }
            $this->setValue('h1',$list->makeName());
            $this->setValue('items',$list->render());
        } catch (Exception $ge) {
            if (method_exists($ge, 'log')) {
                $ge->log();
            }

            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }

    }

}