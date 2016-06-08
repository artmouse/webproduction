<?php
class workflow_status_list_ajax extends Engine_Class {

    public function process() {
        try{
            $id = $this->getArgument('id');
            $workflow = Shop::Get()->getShopService()->getOrderCategoryByID($id);
            $statuses = $workflow->getStatuses();

            $a = array();

            while ($x = $statuses->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName()
                );
            }

            echo json_encode($a);
            exit;
        } catch (Exception $se) {
            echo json_encode('error');
            exit;
        }

    }

}