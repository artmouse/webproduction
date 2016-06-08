<?php
class block_index extends Engine_Class {

    public function process() {
        if ($this->getControlValue('ok')) {
            try {
                SQLObject::TransactionStart();

                $blocks = Shop::Get()->getBlockService()->getBlocksAll();
                while ($x = $blocks->getNext()) {
                    $x->setActive($this->getArgumentSecure('active-'.$x->getId()));
                    if (!$x->getSystem()) {
                        $x->setPosition($this->getArgumentSecure('position-'.$x->getId()));
                        $x->setPositionsort($this->getArgumentSecure('positionsort-'.$x->getId()));
                    }
                    $x->update();
                }

                SQLObject::TransactionCommit();

                $this->setValue('message', 'ok');
            } catch (Exception $e) {
                SQLObject::TransactionRollback();

                $this->setValue('message', 'error');
            }
        }

        // выводим все блоки
        $blocks = Shop::Get()->getBlockService()->getBlocksAll();
        $a = array();
        while ($x = $blocks->getNext()){
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->getName(),
            'active' => $x->getActive(),
            'system' => $x->getSystem(),
            'position' => $x->getPosition(),
            'positionsort' => $x->getPositionsort(),
            );
        }
        $this->setValue('blockArray', $a);
    }

}