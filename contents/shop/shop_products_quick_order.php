<?php
class shop_products_quick_order extends Engine_Class {

    /**
     * Doc
     *
     * @return ShopProduct
     */
    private function _getProduct() {
        return $this->getValue('product');
    }

    public function process() {
        $product = $this->_getProduct();
        if ($product) {
            $this->setValue('productName', $product->getName());
            $this->setValue('productID', $product->getId());
        }

        try{
            $user = $this->getUser();
            $this->setControlValue('qoname', $user->makeName(false, 'lfm'));
            $this->setControlValue('qophone', $user->getPhone());
            $this->setControlValue('qoemail', $user->getEmail());
        } catch (Exception $e) {

        }

        $this->setValue(
            'requiredEmail',
            Shop::Get()->getSettingsService()->getSettingValue('shop-email-required-for-order')
        );

        if ($this->getArgumentSecure('qosubmit')) {
            try {
                SQLObject::TransactionStart();

                if ($this->getControlValue('ajs') != 'ready') {
                    throw new ServiceUtils_Exception('bot');
                }

                // определяем клиента
                $client = false;
                try {
                    $client = $this->getUser();
                    if ($client->isManager()) {
                        $client = false;
                    }
                } catch (Exception $clientEx) {

                }

                if (!$client) {
                    try {
                        $client = Shop::Get()->getUserService()->addUserClient(
                            $this->getControlValue('qoname'),
                            false, // namelast
                            false, // namemiddle
                            false, // typesex
                            false, // company
                            false, // post
                            $this->getControlValue('qoemail'),
                            $this->getControlValue('qophone')
                        );
                        $client->setDistribution(1);
                        $client->update();
                    } catch (Exception $e) {
                        $client = $this->getUser();
                    }
                }

                $product = Shop::Get()->getShopService()->getProductByID($this->getArgument('productid'));

                // оформляем заказ
                $order = Shop::Get()->getShopService()->makeOrderQuick(
                    $client,
                    $product,
                    $this->getControlValue('qoname'),
                    $this->getControlValue('qoemail'),
                    $this->getControlValue('qophone')
                );

                SQLObject::TransactionCommit();

                $products = $order->getOrderProducts();
                $ids = '?ids=';
                while ($x = $products->getNext()) {
                    $ids .= $x->getProductid().',';
                }

                header(
                    'Location: '.
                    Engine::GetLinkMaker()->makeURLByContentID('shop-basket-success').$ids.'&orderid='.$order->getId()
                );

            } catch (ServiceUtils_Exception $e) {
                SQLObject::TransactionRollback();
            }
        }
    }

}