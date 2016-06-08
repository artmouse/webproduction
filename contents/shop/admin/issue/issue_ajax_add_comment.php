<?php
class issue_ajax_add_comment extends Engine_Class {

    public function process() {
        if ($id = $this->getArgumentSecure('issueid')) {
            try {
                $content = trim(strip_tags($this->getArgumentSecure('content')));
                $id = (int)$id;

                if ($id && $content) {
                    $activeUser = Shop::Get()->getUserService()->getUser();
                    $issue = Shop::Get()->getShopService()->getOrderByID($id);

                    Shop::Get()->getShopService()->addOrderComment($issue, $activeUser, $content);
                }
                print $content;
                exit();
            } catch (Exception $e) {
            }
        }
        exit();
    }

}