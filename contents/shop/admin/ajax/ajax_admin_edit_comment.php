<?php
class ajax_admin_edit_comment extends Engine_Class {

    public function process() {
        $id = $this->getArgumentSecure('id');
        $action =  $this->getArgumentSecure('action');
        $text = $this->getArgumentSecure('text');

        try{
            SQLObject::TransactionStart();

            $comment = new CommentsAPI_XComment($id);
            if ($action == 'delete') {
                $comment->setContent(
                    Shop::Get()->getTranslateService()->getTranslateSecure('translate_soobshchenie_udaleno')
                );
            } else {
                $comment->setContent($text);
            }
            $comment->update();

            SQLObject::TransactionCommit();
            $resultArray['id'] = $comment->getId();
            $resultArray['status'] = 'success';
            $resultArray['text'] = $comment->getContent();

            $key = $comment->getKey();
            if (preg_match("/^shop-order-(\d+)$/ius", $key, $r)) {
                $key = 'order-'.$r[1];
            }
            $resultArray['content'] = Shop::Get()->getShopService()->formatComment($comment->getContent(), $key);
        } catch( Exception $e ) {
            SQLObject::TransactionRollback();
            $resultArray['status'] = 'error';
        }
        echo json_encode($resultArray);
        exit;
    }

}