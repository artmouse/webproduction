<?php
class ajax_admin_search extends Engine_Class {

    public function process() {
        try {
            $isOrder = Shop_ModuleLoader::Get()->isImported('order');
            $isContact = Shop_ModuleLoader::Get()->isImported('contact');

            $query = $this->getArgumentSecure('name');
            if (strlen($query)<3) {
                echo json_encode('badLen');
            }

            $a = array();

            // поиск контактов
            if ($isContact) {
                $users = Shop::Get()->getUserService()->searchUsers($query, $this->getUser());
                $users->setLimitCount(10);
                $users->addWhere('typesex', 'company', '<>');
                while ($x = $users->getNext()) {
                    $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(false),
                    'url' => $x->makeURLEdit(),
                    'group' =>'users',
                    'category' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_users')
                    );
                }
            }

            // поиск заказов/проектов
            if ($isOrder) {
                $orders = Shop::Get()->getShopService()->searchOrders($query, $this->getUser());
                $orders->setLimitCount(10);
                $orders->setDateclosed('0000-00-00 00-00');
                $orders->setParentid(0);
                while ($x = $orders->getNext()) {
                    $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(false),
                    'url' => $x->makeURLEdit(),
                    'group' => 'orders',
                    'category' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_ords'),
                    );

                }
            }

            // поиск задач
            if ($isOrder) {
                $orders = Shop::Get()->getShopService()->searchOrders($query, $this->getUser());
                $orders->setLimitCount(10);
                $orders->setDateclosed('0000-00-00 00-00');
                $orders->setIssue(1);
                $orders->addWhere('parentid', 0, '<>');
                while ($x = $orders->getNext()) {
                    $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(false),
                    'url' => $x->makeURLEdit(),
                    'group' => 'orders',
                    'category' => Shop::Get()->getTranslateService()->getTranslateSecure('acl_issue')
                    );
                }
            }

            // поиск компаний
            if ($isContact) {
                $users = Shop::Get()->getUserService()->searchUsers($query, $this->getUser(), true);
                $users->setLimitCount(10);
                $users->setTypesex('company');
                while ($x = $users->getNext()) {
                    $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(false),
                    'url' => $x->makeURLEdit(),
                    'group' =>'users',
                    'category' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_all_company')
                    );
                }
            }

            // поиск продуктов
            $products = Shop::Get()->getShopService()->searchProducts($query, false);
            $products->setLimitCount(10);
            while ($x = $products->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getId().' '.$x->makeName(false),
                'url' => $x->makeURLEdit(),
                'group' => 'products',
                'category' => Shop::Get()->getTranslateService()->getTranslateSecure('acl_products')
                );
            }

            // поиск категорий
            $category = Shop::Get()->getShopService()->searchCategory($query, false);
            $category->setLimitCount(10);
            while ($x = $category->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(false),
                'url' => $x->makeEditURL(),
                'group' => 'category',
                'category' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_category')
                );
            }

            if ($isOrder) {
                $orders = Shop::Get()->getShopService()->searchOrders($query, $this->getUser());
                $orders->setLimitCount(10);
                $orders->addWhere('dateclosed', '0000-00-00 00-00', '<>');
                while ($x = $orders->getNext()) {
                    $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(false),
                    'url' => $x->makeURLEdit(),
                    'group' => 'orders',
                    'category' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_zakritie_zadachi')
                    );
                }
            }

            // выдача результатов
            echo json_encode($a);
            exit;
        } catch (Exception $e) {
            throw $e;
        }

    }

}