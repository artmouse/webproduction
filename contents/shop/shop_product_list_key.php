<?php
class shop_product_list_key extends Engine_Class {

    public function process() {
        try {
            $page = Shop::Get()->getTextPageService()->getTextPageByID(
            $pageID = $this->getArgument('id')
            );

            $list = Shop::Get()->getShopService()->getProductsListByLinkKey(
            $page->getKey()
            );

            $content = Engine::GetContentDriver()->getContent('shop-product-list');
            $content->setValue('items', $list->getProducts());
            $this->setValue('content', $content->render());
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}