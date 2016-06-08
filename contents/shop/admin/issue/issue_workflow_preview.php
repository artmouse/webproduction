<?php
class issue_workflow_preview extends Engine_Class {

    /**
     * @return ShopOrderCategory
     */
    private function _getWorkflow() {
        return $this->getValue('workflow');
    }

    public function process() {
        // статусы заказа
        $statusArray = array();
        // статусы на основе категории
        $category = $this->_getWorkflow();

        $position_y_max = 0;

        $status = $category->getStatuses();
        while ($s = $status->getNext()) {
            $statusArray[] = array(
            'id' => $s->getId(),
            'name' => $s->getName(),
            'colour' => $s->getColour(),
            'positionx' => $s->getX(),
            'positiony' => $s->getY(),
            'width' => $s->getWidth(),
            'height' => $s->getHeight(),
            'default' => $s->getDefault()
            //'description' => $s->getContent(),
            );

            // максимальная высота workflow'a
            if ($position_y_max < $s->getY() + $s->getHeight()) {
                $position_y_max = $s->getY() + $s->getHeight();
            }
        }

        if ($position_y_max > 0) {
            $position_y_max += 50;
        }
        $this->setValue('position_y_max', $position_y_max);

        $changeArray = array();
        $changes = new XShopOrderStatusChange();
        $changes->setCategoryid($category->getId());
        while ($x = $changes->getNext()) {
            if ($x->getElementfromid() == $x->getElementtoid()) {
                continue;
            }
            $changeArray[$x->getElementfromid()][$x->getElementtoid()] = 1;
        }
        $this->setValue('changeArray', $changeArray);

        $this->setValue('statusArray', $statusArray);

        // список менеджеров
        $managers = Shop::Get()->getUserService()->getUsersManagers($this->getUser());
        $a = array();
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(true, false),
            );
        }
        $this->setValue('managerStatusArray', $a);

        // передаем параметры workflow'a
        $this->setValue('defaultManagerID', $category->getManagerid());
        $this->setValue('defaultIssueName', $category->getIssuename(), true);
        try{
            if ($category->getStatusDefault()) {
                $this->setValue('defaultStatusName', $category->getStatusDefault()->getName());
                $this->setValue('defaultStatusId', $category->getStatusDefault()->getId());
            }
        } catch (Exception $e) {

        }

        if ($category->getTerm()) {
            $dateto = DateTime_Object::Now()->addDay(+$category->getTerm())->setFormat('Y-m-d')->__toString();
            $this->setValue('defaultDateTo', $dateto);
        }

        $this->setValue('userId', $this->getUser()->getId());
    }

}