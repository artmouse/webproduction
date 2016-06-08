<?php
class shop_products_notice_of_availability_ajax extends Engine_Class {

    public function process() {
        $productID = $this->getArgument('productid');
        $email = $this->getArgumentSecure('email');
        $name = $this->getArgumentSecure('name');

        $product = Shop::Get()->getShopService()->getProductByID($productID);
        
        try {
            Shop::Get()->getProductsNoticeOfAvailabilityService()->addProductNoticeOfAvailability(
                $product,
                $name,
                $email
            );
            print json_encode(array('send' => true));
            // если успех создать, или обновить данные клиента
            try {
                $user = $this->getUser();
                if (!$user->getEmail()) {
                    $user->setEmail($email);
                    $user->update();
                }
            } catch (Exception $e) {
                $user = Shop::Get()->getUserService()->addUserClient(
                    $name,
                    false,
                    false,
                    false,
                    false,
                    false,
                    $email
                );
            }
        } catch (ServiceUtils_Exception $e) {
            print json_encode(array('send' => false, 'error' => implode($e->getErrorsArray())));
        }
    }

}