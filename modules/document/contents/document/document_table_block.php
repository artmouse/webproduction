<?php
class document_table_block extends Engine_Class {

    public function process() {
        $documents = $this->_getDocuments();

        if ($this->getControlValue('status') == 'new') {
            $documents->addWhere('cdate', '0000-00-00 00:00:00', '>');
            $documents->filterSdate('0000-00-00 00:00:00');
            $documents->filterBdate('0000-00-00 00:00:00');
            $documents->filterAdate('0000-00-00 00:00:00');
        }

        if ($this->getControlValue('status') == 'sent') {
            $documents->addWhere('sdate', '0000-00-00 00:00:00', '>');
            $documents->filterBdate('0000-00-00 00:00:00');
            $documents->filterAdate('0000-00-00 00:00:00');
        }

        if ($this->getControlValue('status') == 'recieved') {
            $documents->addWhere('bdate', '0000-00-00 00:00:00', '>');
            $documents->filterAdate('0000-00-00 00:00:00');
        }

        if ($this->getControlValue('status') == 'archive') {
            $documents->addWhere('adate', '0000-00-00 00:00:00', '>');
        }

        $clientIDArray = $this->getArgumentSecure('filterclientid', 'array');
        $linkkey1Array = array();
        foreach ($clientIDArray as $clId) {
            try {
                $user = Shop::Get()->getUserService()->getUserByID($clId);
                if ($user->getTypesex() == 'company') {
                    $allUsers = Shop::Get()->getUserService()->getUsersAll();
                    $allUsers->setCompany($user->getCompany());
                    $allUsers->addWhereQuery('(`id` IN (SELECT `userid` FROM `shoporder`))');
                    while ($x = $allUsers->getNext()) {
                        $linkkey1Array[] = 'User-'.$x->getId();
                    }
                }

                $linkkey1Array[] = 'User-'.$clId;
            } catch (Exception $e) {

            }
        }
        $linkkey1Array = array_unique($linkkey1Array);
        $documents->addWhereArray($linkkey1Array, 'linkkey');

        $orderIDArray = $this->getArgumentSecure('filterorderid', 'array');
        $linkkey2Array = array();
        foreach ($orderIDArray as $orderID) {
            $linkkey2Array[] = 'ShopOrder-'.$orderID;
        }
        $documents->addWhereArray($linkkey2Array, 'linkkey');

        if ($this->getArgumentSecure('filtertemplateid')) {
            $documents->setTemplateid($this->getArgumentSecure('filtertemplateid'));
        }

        $groupName = $this->getArgumentSecure('filtergroupname');
        if ($groupName) {
            $templates = DocumentService::Get()->getDocumentTemplatesActive();
            $templates->filterGroupname($groupName);
            $a = array(-1);
            while ($x = $templates->getNext()) {
                $a[] = $x->getId();
            }
            $documents->filterTemplateid($a);
        }

        $direction = $this->getArgumentSecure('filterdirection');
        if ($direction) {
            $templates = DocumentService::Get()->getDocumentTemplatesActive();
            $templates->filterDirection($direction);
            $a = array(-1);
            while ($x = $templates->getNext()) {
                $a[] = $x->getId();
            }
            $documents->filterTemplateid($a);
        }

        $datasource = new Datasource_Document();
        $datasource->setSQLObject($documents);

        $table = new Shop_ContentTable($datasource);

        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-document-control', 'id');
        $table->addField($field);
        $table->getField('id')->setName('#');

        $field = new Forms_ContentFieldControlLink('number', 'shop-admin-document-control', 'id');
        $table->addField($field);
        $table->getField('number')->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_document_number')
        );

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-document-control', 'id');
        $table->addField($field);
        $table->getField('name')->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_title_of_document')
        );

        $this->setValue('table', $table->render());

        // менеджеры
        $managers = Shop::Get()->getUserService()->getUsersManagers($this->getUser());
        $a = array();
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(true, 'lfm'),
            );
        }
        $this->setValue('managerArray', $a);

        // Выбранные из клиентов
        $clientArray = array();
        foreach ($clientIDArray as $clientID) {
            try {
                $client = Shop::Get()->getUserService()->getUserByID($clientID);

                $clientArray[] = array(
                'id' => $clientID,
                'text' =>  $client->getTypesex() == 'company' ? 'Компания '.$client->getCompany():$client->makeName()
                );
            } catch (ServiceUtils_Exception $pe) {

            }
        }
        $this->setValue('filterClientArray', $clientArray);

        // выбранные заказы
        $orderArray = array();
        foreach ($orderIDArray as $orderID) {
            try {
                $order = Shop::Get()->getShopService()->getOrderByID($orderID);

                $orderArray[] = array(
                'id' => $orderID,
                'text' =>  $order->makeName(true)
                );
            } catch (ServiceUtils_Exception $pe) {

            }
        }
        $this->setValue('filterOrderArray', $orderArray);

        // список шаблонов
        $templates = DocumentService::Get()->getDocumentTemplatesActive();
        $templateArray = array();
        while ($x = $templates->getNext()) {
            $templateArray[] = array(
            'id' => $x->getId(),
            'name' => htmlspecialchars($x->getName()),
            );
        }
        $this->setValue('templateArray', $templateArray);

        // группы документов
        $templates = DocumentService::Get()->getDocumentTemplatesActive();
        $templates->setGroupByQuery('groupname');
        $a = array();
        while ($x = $templates->getNext()) {
            if ($x->getGroupname()) {
                $a[] = $x->getGroupname();
            }
        }
        $this->setValue('groupArray', $a);
    }

    /**
     * Получить переданные в контент документы
     *
     * @return ShopDocument
     */
    private function _getDocuments() {
        return $this->getValue('documents');
    }
}