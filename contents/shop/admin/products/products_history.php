<?php
class products_history extends Engine_Class {

    public function process() {
        try {
            $form = new Shop_ContentTable($this->_getDataSource());
            $form->removeField('id');
            $form->removeField('productid');
            $this->setValue('form', $form->render());

            // список тех кто вносил изменения
            $x = new XShopProductChange();
            $x->setProductid($this->getArgument('id'));
            $x->setOrder('id', 'DESC');
            $x->setGroupByQuery('userid');
            $a = array();
            while ($y = $x->getNext()) {
                try {
                    $user = Shop::Get()->getUserService()->getUserByID($y->getUserid());
                    $a[] = array(
                        'id' => $user->getId(),
                        'name' => $user->makeName(),
                    );
                } catch (Exception $e) {

                }
            }
            $this->setValue('authorArray', $a);

            $menu = Engine::GetContentDriver()->getContent('shop-admin-products-menu');
            $menu->setValue('selected', 'history');
            $this->setValue('menu', $menu->render());
        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

    protected function _getDataSource() {

        $datasource = new Datasource_ProductsHistory($this->getArgument('id'));

        $userID = $this->getControlValue('userid', 'int');

        // echo $userID;exit;

        if ($this->getControlValue('systemchange')) {
            $datasource->getSQLObject()->addWhereQuery('(`userid` >= 0 )');
        } else {
            $datasource->getSQLObject()->addWhereQuery('(`userid` != 0 )');
        }

        if ($userID) {
            $datasource->getSQLObject()->addWhereQuery('(`userid` = ' . $userID . ')');
        }

        $fieldkey = trim(strip_tags($this->getControlValue('fieldkey')));
        if ($fieldkey) {
            $datasource->getSQLObject()->addWhereQuery('(`key` LIKE "%' . $fieldkey . '%" )');
        }

        $filterCdateFrom = $this->getArgumentSecure('filtercdatefrom', 'date');
        if ($filterCdateFrom) {
            $datasource->getSQLObject()->addWhere('cdate', $filterCdateFrom, '>=');
        }

        $filterCdateTo = $this->getArgumentSecure('filtercdateto', 'date');
        if ($filterCdateTo) {
            $datasource->getSQLObject()->addWhere('cdate', $filterCdateTo.' 23:59:59', '<=');
        }


        // echo $datasource->getSQLObject();exit;

        return $datasource;
    }

}