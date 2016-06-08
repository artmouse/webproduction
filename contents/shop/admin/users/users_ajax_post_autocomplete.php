<?php
class users_ajax_post_autocomplete extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgumentSecure('name');

            $postArray = Shop::Get()->getUserService()->searchPosts($query);

            echo json_encode($postArray);
            exit();
        } catch (Exception $e) {

        }
    }

}