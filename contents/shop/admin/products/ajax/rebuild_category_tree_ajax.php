<?php
class rebuild_category_tree_ajax extends Engine_Class {

    public function process() {


       $categoryTree = Engine::GetContentDriver()->getContent('product-category-tree');
       $categoryTree->setValue('categoryid', $this->getArgumentSecure('categoryid'));

       $data = array();
       $data['html'] = $categoryTree->render();
       echo json_encode($data);
       exit;
    }



}