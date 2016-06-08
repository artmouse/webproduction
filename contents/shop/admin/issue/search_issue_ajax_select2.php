<?php
class search_issue_ajax_select2 extends Engine_Class {

    /**
     * хз шо)
     *
     * @todo переделать по нормальному, а то куча API...
     */
    public function process() {
        $query = $this->getArgumentSecure('name');
        if (strlen($query) < 3) {
            echo json_encode('badLen');
            exit();
        }

        $a = array();

        // поиск проектов
        $projects = Shop::Get()->getShopService()->searchOrders($query, $this->getUser(), 'project');
        $projects->setType('project');
        $projects->setDateclosed('0000-00-00 00:00:00');
        $projects->setLimitCount(10);
        while ($x = $projects->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(false),
            'manager' => $x->getManagerOrAuthor()->getId(),
            'category' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_proekti')
            );
        }

        // поиск заказов
        $orders = Shop::Get()->getShopService()->searchOrders($query, $this->getUser(), 'order');
        $orders->addWhereArray(array('', 'order'), 'type');
        $orders->setDateclosed('0000-00-00 00-00');
        $orders->setLimitCount(10);
        while ($x = $orders->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(false),
            'manager' => $x->getManagerOrAuthor()->getId(),
            'category' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_ords'),
            );
        }

        // поиск задач
        $issues = Shop::Get()->getShopService()->searchOrders($query, $this->getUser(), 'issue');
        $issues->setType('issue');
        $issues->setDateclosed('0000-00-00 00-00');
        $issues->setLimitCount(10);
        while ($x = $issues->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(false),
            'manager' => $x->getManagerOrAuthor()->getId(),
            'category' => Shop::Get()->getTranslateService()->getTranslateSecure('acl_issue'),
            );
        }

        // закрытые проекты
        $projects = Shop::Get()->getShopService()->searchOrders($query, $this->getUser(), 'project');
        $projects->setType('project');
        $projects->addWhere('dateclosed', '0000-00-00 00-00', '<>');
        $projects->setLimitCount(10);
        while ($x = $projects->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(false),
            'manager' => $x->getManagerOrAuthor()->getId(),
            'category' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_zakritie_proekti')
            );
        }

        // закрытые заказов
        $orders = Shop::Get()->getShopService()->searchOrders($query, $this->getUser(), 'order');
        $orders->addWhereArray(array('', 'order'), 'type');
        $orders->addWhere('dateclosed', '0000-00-00 00-00', '<>');
        $orders->setLimitCount(10);
        while ($x = $orders->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(false),
            'manager' => $x->getManagerOrAuthor()->getId(),
            'category' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_ords'),
            );
        }

        // закрыты задачи
        $issues = Shop::Get()->getShopService()->searchOrders($query, $this->getUser(), 'issue');
        $issues->addWhere('dateclosed', '0000-00-00 00-00', '<>');
        $issues->setLimitCount(10);
        while ($x = $issues->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(false),
            'manager' => $x->getManagerOrAuthor()->getId(),
            'category' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_zakritie_zadachi')
            );
        }

        // выдача результатов
        echo json_encode($a);
        exit;
    }

}