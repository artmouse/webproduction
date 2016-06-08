<?php
class shop_tpl extends Engine_Class {

    public function process() {
        $url = Engine::GetURLParser()->getCurrentURL();
        if (!preg_match("/^\/admin\//ius", $url) && !preg_match("/^\/doc\//ius", $url)) {
            header('Location: /admin/');
            exit();
        }

        $this->setValue('title', Engine::GetHTMLHead()->getTitle());
        $this->setValue('engine_includes', Engine::GetHTMLHead()->render());
    }

}