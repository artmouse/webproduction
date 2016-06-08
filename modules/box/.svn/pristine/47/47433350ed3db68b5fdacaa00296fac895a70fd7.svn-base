<?php
class mind_index extends Engine_Class {

    public function process() {
        try {
            $issues = $this->_getIssues();
            $issues->setOrder('id', 'ASC');
            //$issues->setLimit(0, 0);

            // обновить json-файл
            IssueService::Get()->updateIssueMindJson($issues);

            // менеджеры
            $managers = Shop::Get()->getUserService()->getUsersManagers();
            $a = array();
            while ($x = $managers->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                );
            }
            $this->setValue('managerArray', $a);

            // бизнес-процессы
            $workflows = Shop::Get()->getShopService()->getOrderCategoryAll();
            $workflows->setType('issue');
            $a = array();
            while ($x = $workflows->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                );
            }
            $this->setValue('categoryArray', $a);
        } catch (Exception $pe) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }

    }

    /**
     * @return ShopOrder
     */
    private function _getIssues() {
        return $this->getValue('issue');
    }

}