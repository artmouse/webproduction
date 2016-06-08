<?php
class product_preview extends Engine_Class {

    public function process() {
        try {
            $product = Shop::Get()->getShopService()->getProductByID(
                $this->getArgument('id')
            );

            $this->setValue('id', $product->getId());
            $this->setValue('code1c', $product->getCode1c());
            $this->setValue('articul', $product->getArticul());
            $this->setValue('name', $product->makeName());
            $this->setValue('url', $product->makeURLEdit());
            $this->setValue('description', $product->makeCharacteristicsString());
            if ($product->getImage()) {
                $this->setValue('image', $product->makeImageThumb(200, 200));
            }

            $this->setValue('price', $product->getPrice());
            $this->setValue('pricebase', $product->getPricebase());

            try {
                $this->setValue('currency', $product->getCurrency()->getSymbol());
            } catch (Exception $e) {

            }

            try {
                $this->setValue('categoryPath', $product->getCategory()->makePathName());
            } catch (Exception $e) {

            }

            $this->setValue('inBasket', Shop::Get()->getShopService()->isProductInBasket($product));

            $this->setValue('urlBarcode', $product->makeURLBarcode());
            $this->setValue('urlPricecode', $product->makeURLPricecode());
            $this->setValue('source', $product->getSource());

        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}