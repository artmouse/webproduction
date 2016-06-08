<?php
class comment_template extends Engine_Class {

    public function process() {
        try{
            $comments = new XShopCommentTemplate();
            $commentArray = array();
            while ($x = $comments->getNext()) {
                $commentArray[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    'text' => $x->getText(),
                    'url' => '/admin/comment/template/'.$x->getId().'/'
                );
            }

            $this->setValue('commentArray', $commentArray);
        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}