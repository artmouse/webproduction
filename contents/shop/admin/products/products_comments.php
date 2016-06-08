<?php
class products_comments extends Engine_Class {

    public function process() {
        try {
            $product = Shop::Get()->getShopService()->getProductByID(
            $this->getArgument('id')
            );

            $table = new Shop_ContentTable(new Datasource_ProductComments($product->getId()));
            $table->removeField('productid');

            $field = new Forms_ContentFieldControlLink('cdate', 'shop-admin-products-comments-control', 'key');
            $table->addField($field);
            $table->getField('cdate')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_date_time'));

            $this->setValue('table', $table->render());

            $menu = Engine::GetContentDriver()->getContent('shop-admin-products-menu');
            $menu->setValue('selected', 'comments');
            $this->setValue('menu', $menu->render());
        } catch(Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}