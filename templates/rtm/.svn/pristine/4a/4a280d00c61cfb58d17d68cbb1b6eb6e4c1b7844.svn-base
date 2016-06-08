<?php
class shop_product_list_filters extends Engine_Class {

    public function process() {
        $a = $min = 0;
        $b = $this->getValue('maxprice');
        $max = $this->getValue('maxWeight');

        $tmp = $this->getControlValue('filterpricefrom');
        if ($tmp) {
            $a = $tmp;
        }

        $tmp = $this->getControlValue('filterpriceto');
        if ($tmp) {
            $b = $tmp;
        }

        $this->setValue('filterpricefrom_value', $a);
        $this->setValue('filterpriceto_value', $b);

        $tmp = $this->getControlValue('filterweightfrom');
        if ($tmp) {
            $min = $tmp;
        }

        $tmp = $this->getControlValue('filterweightto');
        if ($tmp) {
            $max = $tmp;
        }

        $this->setValue('filterWeightfrom_value', $min);
        $this->setValue('filterWeightto_value', $max);

    }

}