<?php
class shop_products_found_cheaper extends Engine_Class {

    public function process() {
        if ($this->getArgumentSecure('foundcheaper')) {
            try {
                if ($this->getControlValue('ajs') != 'ready') {
                    throw new ServiceUtils_Exception('bot');
                }

                $product = Shop::Get()->getShopService()->getProductByID(
                    $this->getArgument('productid')
                );

                try {
                    $user = Shop::Get()->getUserService()->addUserClient(
                        $this->getControlValue('name'),
                        false, // namelast
                        false, // namemiddle
                        false, // typesex
                        false, // company
                        false, // post
                        $this->getControlValue('email'),
                        $this->getControlValue('phone'),
                        $this->getControlValue('city') // address
                    );
                } catch (Exception $e) {

                }
                $clientAddress = $this->getControlValue('city');
                $where = $this->getControlValue('where');
                $price = $this->getControlValue('price');
                $comments = "Найдено дешевле. Где дешевле: $where Цена: $price.";

                $order = Shop::Get()->getShopService()->makeOrderQuick(
                    $user,
                    $product,
                    $this->getControlValue('name'),
                    $this->getControlValue('email'),
                    $this->getControlValue('phone')
                );
                
                $order->setComments($comments);
                
                if ($clientAddress) {
                    $order->setClientaddress($clientAddress);
                }
                
                $order->update();

                $this->setValue('foundCheaperMessage', 'ok');
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('foundCheaperMessage', 'error');
                $this->setValue('foundCheaperErrorArray', $e->getErrorsArray());
            }
        }
    }

}