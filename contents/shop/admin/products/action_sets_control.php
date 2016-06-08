<?php
class action_sets_control extends Engine_Class {

    public function process() {
        try {
            $actionSet = Shop::Get()->getShopService()->getActionSetById($this->getArgument('id'));
            $product = Shop::Get()->getShopService()->getProductByID(
                $actionSet->getProductid()
            );
            $this->setValue(
                'productActionUrl',
                Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-action-set', $product->getId())
            );

            $this->setValue('productid', $product->getId());

            if ($this->getControlValue('update')) {
                $errorArray = array();
                $name = trim(strip_tags($this->getControlValue('name')));
                if (!$name) {
                    $errorArray[] = Shop::Get()->getTranslateService()->getTranslateSecure(
                        'translate_neobhodimo_ukazat_nazvanie_nabora'
                    );
                } else {
                    $actionSet->setName($name);
                }

                $actionSet->setHidden($this->getControlValue('hidden'));
                $actionSet->update();

                // добавляем товар в заказ
                $this->_addProductToActionSet($actionSet, $product);
                // удаляем из набора
                $this->_removeFromActionSet($actionSet);

                $discountArray = $this->getArgumentSecure('discount');

                foreach ($discountArray as $productID => $discount) {
                    $discount = intval($discount);
                    if ($discount < 0 || $discount > 100) {
                        $errorArray[] = Shop::Get()->getTranslateService()->getTranslateSecure(
                            'translate_nekorrektnaya_skidka_dlya_tovara_'
                        ).$productID;
                        continue;
                    }

                    if ($productID == $product->getId()) {
                        $actionSet->setDiscount($discount);
                        $actionSet->update();
                        continue;
                    }

                    $product2ActionSet = new XProduct2ActionSet();
                    $product2ActionSet->setActionid($actionSet->getId());
                    $product2ActionSet->setProductid($productID);
                    if ($product2ActionSet->select()) {
                        $product2ActionSet->setDiscount($discount);
                        $product2ActionSet->update();
                    }
                }

                // echo'<pre>';print_r($discountArray);echo'</pre>';exit;

                $this->setValue('errorArray', $errorArray);

            }

            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $this->setValue('currencyDefault', $currencyDefault->getSymbol());

            $setSum = 0;

            $a = array();
            $actioPrice = Shop::Get()->getShopService()->makeActionPrice(
                $product,
                $currencyDefault,
                $actionSet->getDiscount()
            );

            $a[] = array(
                'productid' => $product->getId(),
                'name' => $product->getName(),
                'priceNoDiscount' => $product->makePrice($currencyDefault, false),
                'discount' => $product->getDiscount(),
                'priceWithDiscount' => $product->makePrice($currencyDefault),
                'discountAction' => $actionSet->getDiscount(),
                'actionPrice' => $actioPrice,
                'image' => $product->makeImageThumb(100),
                'url' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-products-edit', $product->getId()),
            );

            $setSum += $actioPrice;

            $product2ActionSet = Shop::Get()->getShopService()->getActionSetProduct($actionSet);

            while ($p = $product2ActionSet->getNext()) {
                $actioPrice = Shop::Get()->getShopService()->makeActionPrice(
                    $p,
                    $currencyDefault,
                    $p->getField('actiondiscount')
                );
                $a[] = array(
                    'productid' => $p->getId(),
                    'name' => $p->getName(),
                    'priceNoDiscount' => $p->makePrice($currencyDefault, false),
                    'discount' => $p->getDiscount(),
                    'priceWithDiscount' => $p->makePrice($currencyDefault),
                    'discountAction' => $p->getField('actiondiscount'),
                    'actionPrice' => $actioPrice,
                    'image' => $p->makeImageThumb(100),
                    'url' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-products-edit', $p->getId()),
                );
                $setSum += $actioPrice;
            }

            $this->setValue('setSum', round($setSum));
            $this->setValue('productsArray', $a);
            $this->setControlValue('name', $actionSet->getName());
            $this->setControlValue('hidden', $actionSet->getHidden());

        } catch(Exception $ge) {

            //print_r($ge);exit;

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

    /**
     * RemoveFromActionSet
     *
     * @param XShopActionSet $actionSet
     */
    private function _removeFromActionSet(XShopActionSet $actionSet) {
        $removeArray = $this->getArgumentSecure('remove');
        if ($removeArray) {
            foreach ($removeArray as $productID) {
                $product2ActionSet = new XProduct2ActionSet();
                $product2ActionSet->setActionid($actionSet->getId());
                $product2ActionSet->setProductid($productID);
                $product2ActionSet = $product2ActionSet->getNext();
                if ($product2ActionSet) {
                    $product2ActionSet->delete();
                }
            }
        }
    }

    /**
     * AddProductToActionSet
     *
     * @param XShopActionSet $actionSet
     * @param ShopProduct $product
     */
    private function _addProductToActionSet(XShopActionSet $actionSet, ShopProduct $product) {
        if (preg_match_all("/#([\d\w\pL]+)/ius", $this->getArgumentSecure('productlist'), $r)) {
            foreach ($r[1] as $addProductID) {
                if (!$addProductID) {
                    continue;
                }
                if ($addProductID == $product->getId()) {
                    continue;
                }
                $product2ActionSet = new XProduct2ActionSet();
                $product2ActionSet->setActionid($actionSet->getId());
                $product2ActionSet->setProductid($addProductID);
                if (!$product2ActionSet->select()) {
                    $product2ActionSet->insert();
                }
            }

        }
    }

    /**
     * Обработчик удаления товара из заказа
     *
     * @param ShopOrderProduct $op
     */
    private function _deleteOrderProduct(ShopOrderProduct $op) {
        try {
            $deleteID = $this->getArgument('delete'.$op->getId());

            $event = Events::Get()->generateEvent('shopOrderProductDeleteBefore');
            $event->setOrderProduct($op);
            $event->notify();

            $op->delete();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }



}