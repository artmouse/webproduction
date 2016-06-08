<?php
class products_orders extends Engine_Class {

    public function process() {
        try {
            $product = Shop::Get()->getShopService()->getProductByID(
                $this->getArgument('id')
            );
            if (!$this->getArgumentSecure('ok')) {
                $datefrom = DateTime_Formatter::DateISO9075(DateTime_Object::Now()->addMonth(-1));
                $dateto = DateTime_Formatter::DateISO9075(DateTime_Object::Now());
                $this->setControlValue('dateFrom', $datefrom);
                $this->setControlValue('dateTo', $dateto);
            }

            $this->setValue('productid', $product->getId());
            $this->setValue('name', $product->getName());
            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_tovar_').$product->getId()
            );

            $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
            $orders->leftJoinTable('shoporderproduct', '`shoporderproduct`.`orderid`= `shoporder`.`id`');
            $orders->addFieldQuery('`shoporderproduct`.`productid`');
            $orders->addWhereQuery("`shoporderproduct`.`productid` = {$product->getId()}");

            $orders->setOrder('cdate', 'DESC');
            if ($this->getControlValue('dateFrom')) {
                $datefrom = DateTime_Corrector::CorrectDateTime($this->getControlValue('dateFrom'));
                $orders->addWhere('cdate', $datefrom, '>=');
            }
            if ($this->getControlValue('dateTo')) {
                $dateto = DateTime_Corrector::CorrectDateTime($this->getControlValue('dateTo').' 23:59:59');
                $orders->addWhere('cdate', $dateto, '<=');
            }
            $a = array();
            while ($x = $orders->getNext()) {
                try {
                    $user = Shop::Get()->getUserService()->getUserByID($x->getUserid())->makeInfoArray();
                } catch (Exception $e) {
                    $user = false;
                }

                $a[] = array(
                    'user' => $user,
                    'cdate' => $x->getCdate(),
                    'orderId' => $x->getId(),
                    'orderUrl' => $x->makeURLEdit()
                );

            }
            $this->setValue('orderArray', $a);

            $orders->addFieldQuery("DATE(`cdate`) as 'dd', COUNT(*) as 'cnt'");
            $orders->setGroupByQuery("(`dd`)");
            $orders->setOrder('cdate', 'ASC');
            while ($f = $orders->getNext()) {
                $b[]=array(
                    'date' => $f->getField('dd'),
                    'cnt' => $f->getField('cnt')
                );
            }
            if (isset($b)) {
                $this->setValue('ordersArray', $b);
            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-products-menu');
            $menu->setValue('selected', 'order');
            $this->setValue('menu', $menu->render());
        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}