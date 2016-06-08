<?php
class ajax_user_post_search extends Engine_Class {

    public function process() {
        $query = $this->getArgument('name');
        $resultArray = Shop::Get()->getUserService()->searchPosts($query);
        echo json_encode($resultArray);
        exit;
    }

}