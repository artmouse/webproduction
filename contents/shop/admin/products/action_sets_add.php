<?php
class action_sets_add extends Engine_Class {

    public function process() {
        try {
            $product = Shop::Get()->getShopService()->getProductByID(
                $this->getArgument('id')
            );

            $this->setValue('productActionUrl',Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-action-set',$product->getId()));

            $form = new Forms_ContentForm(new Datasource_ActionProductSet($product,true));
            $form->denyDelete();
            $form->denyUpdate();

            $this->setValue('form', $form->render());

        } catch(Exception $ge) {
            Engine::Get()->getRequest()->setContentNotFound();
        }

    }
}