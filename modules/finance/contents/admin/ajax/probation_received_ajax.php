<?php
class probation_received_ajax extends Engine_Class {

    public function process() {
        $probation = new XFinanceProbation($this->getArgument('paymentId'));

        $probation->setReceived($this->getArgumentSecure('value'));
        $probation->update();
    }

}