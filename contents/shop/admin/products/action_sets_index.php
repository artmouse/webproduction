<?php
class action_sets_index extends Engine_Class {

    public function process() {
        try {
            $product = Shop::Get()->getShopService()->getProductByID(
                $this->getArgument('id')
            );
            $table = new Shop_ContentTable(new Datasource_ActionProductSet($product));

            $field = new Forms_ContentFieldControlLink('name', 'shop-admin-action-set-control','id');
            $table->addField($field);

            $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title'));

            $this->setValue('table', $table->render());

            $menu = Engine::GetContentDriver()->getContent('shop-admin-products-menu');
            $menu->setValue('selected', 'action_set');
            $this->setValue('menu', $menu->render());
            $this->setValue('productid', $product->getId());

        } catch(Exception $ge) {
            Engine::Get()->getRequest()->setContentNotFound();
        }

    }

}