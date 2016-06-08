<?php
class products_lists extends Engine_Class {

    public function process() {
        try {
            $product = Shop::Get()->getShopService()->getProductByID(
                $this->getArgument('id')
            );

            $a = new XShopProduct2List();
            $a->setProductid($product->getId());
            $b = array(-1);
            while($x = $a->getNext()){
                $b[] = $x->getListid();
            }

            $table = new Shop_ContentTable(new Datasource_ProductsList($b));

            $field = new Forms_ContentFieldControlLink('name', 'shop-admin-products-list-control', 'key');
            $table->addField($field);

            $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name_list_of_the_products'));

            $this->setValue('table', $table->render());

            $menu = Engine::GetContentDriver()->getContent('shop-admin-products-menu');
            $menu->setValue('selected', 'lists');
            $this->setValue('menu', $menu->render());
            $this->setValue('productid', $product->getId());

        } catch(Exception $ge) {
            Engine::Get()->getRequest()->setContentNotFound();
        }

    }

}