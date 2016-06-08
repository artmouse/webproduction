<?php
class invoice_index extends Engine_Class {

    public function process() {
        $userIDArray = $this->getArgumentSecure('userid', 'array');
        $contractorIDArray = $this->getArgumentSecure('contractorid', 'array');
        $clientIDArray = $this->getArgumentSecure('clientid', 'array');

        // таблица
        $table = new Shop_ContentTable(
            new Datasource_FinanceInvoice(
                $this->getArgumentSecure('linkkey'),
                $this->getControlValue('datefrom'),
                $this->getControlValue('dateto'),
                $clientIDArray,
                $contractorIDArray,
                $userIDArray
            )
        );

        $field = new Forms_ContentFieldControlLink('id', 'shop-finance-invoice-view', 'id');
        $field->setName('#');
        $table->addField($field);

        $field = new Forms_ContentFieldControlLink('cdate', 'shop-finance-invoice-view', 'id');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sozdan'));
        $table->addField($field);

        $this->setValue('table', $table->render());

        // клиенты
        $users = Shop::Get()->getUserService()->getUsersAll();
        $users->addWhereQuery('(`id` IN (SELECT `clientid` FROM `financeinvoice`))');
        $a = array();
        while ($x = $users->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName()
            );
        }
        $this->setValue('clientArray', $a);

        // менеджеры
        $users = Shop::Get()->getUserService()->getUsersAll();
        $users->addWhereQuery('(`id` IN (SELECT `userid` FROM `financeinvoice`))');
        $a = array();
        while ($x = $users->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName()
            );
        }
        $this->setValue('userArray', $a);

        // юр лица
        $contractors = Shop::Get()->getShopService()->getContractorsActive();
        $contractorArray = array();
        while ($c = $contractors->getNext()) {
            $contractorArray[] = array(
            'id' => $c->getId(),
            'name' => $c->getName(),
            );

        }

        $this->setValue('contractorArray', $contractorArray);

        // выбранные мульти-фильтры
        $this->setValue('contractorSelectedArray', $contractorIDArray);
        $this->setValue('userSelectedArray', $userIDArray);
        $this->setValue('clientSelectedArray', $clientIDArray);
    }

}