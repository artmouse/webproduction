<?php
class products_nameformula extends Engine_Class {

    public function process() {
        // имя input-ов
        try {
            $this->setValue('name', $this->getArgument('name'));
            $this->setValue('val', $this->getArgumentSecure('value'));
        } catch (Exception $e) {
            $this->setValue('name', 'name');
            $this->setValue('val', $this->getArgumentSecure('value'));
        }

        try {
            $category = Shop::Get()->getShopService()->getCategoryByID(
                $this->getArgument('categoryid')
            );

            $nameFormula = trim($category->getNameformula());

            if (!$nameFormula) {
                throw new ServiceUtils_Exception();
            }

            // парсим формулу
            $formulaArray = explode(';', $nameFormula);
            $a = array();
            foreach ($formulaArray as $part) {
                $partName = $part;
                $va = array();

                if (preg_match("/\((.+?)\)/ius", $part, $r)) {
                    $partName = str_replace($r[0], '', $partName);
                    $tmp = explode(',', $r[1]);
                    foreach ($tmp as $tmpx) {
                        $tmpx = trim($tmpx);
                        if ($tmpx) {
                            $va[] = $tmpx;
                        }
                    }
                }

                $a[] = array(
                'name' => $partName,
                'valuesArray' => $va,
                );
            }
            $this->setValue('formulaArray', $a);
        } catch (Exception $e) {

        }
    }

}