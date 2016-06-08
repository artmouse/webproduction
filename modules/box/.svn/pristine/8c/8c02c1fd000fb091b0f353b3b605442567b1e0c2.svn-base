<?php
class report_callrouting extends Engine_Class {

    public function process() {
        $call = new XCallRouting();
        if ($this->getArgumentSecure('ok')) {
            if ($this->getControlValue('from')) {
                $call->addWhere('from', "%" . $this->getControlValue('from') . "%", "LIKE");
            }
            if ($this->getControlValue('to')) {
                $call->addWhere('to', "%" . $this->getControlValue('to') . "%", "LIKE");
            }
            if ($this->getControlValue('name')) {
                $call->addWhere('name', "%" . $this->getControlValue('name') . "%", "LIKE");
            }
            if ($this->getControlValue('comment')) {
                $call->addWhere('comment', "%" . $this->getControlValue('comment') . "%", "LIKE");
            }
        }

        $table = new Shop_ContentTable(new Datasource_CallRouting($call));
        $this->setValue('table', $table->render());
        
    }

}