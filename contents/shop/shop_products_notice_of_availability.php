<?php
class shop_products_notice_of_availability extends Engine_Class {

    public function process() {
        $email = $this->getUserSecure() ? $this->getUserSecure()->getEmail() : false;
        $name = $this->getUserSecure() ? $this->getUserSecure()->getName() : false;
        $this->setValue('email', $email);
        $this->setValue('name', $name);
        if ($email) {
            $render = Engine::GetContentDriver()->getContent('shop-product');
            $render->setValue('emailAndAuthorized', 'ok');
        }
    }

}