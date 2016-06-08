<?php

class Shop_ContentField_Workflows extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false) {
        parent::__construct($optionsArray);
        $this->addOption(0, '---');

        try {
            $workFlows = Shop::Get()->getShopService()->getWorkflowsAll();
            $workFlows->setType('order');
            $workFlows->setHidden(0);

            while ($x = $workFlows->getNext()) {
                $this->addOption($x->getId(), $x->makeName());
            }

        } catch (Exception $e) {

        }

    }

}