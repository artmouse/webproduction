<?php
class standard_create extends Engine_Class {

    public function process() {
        try {
            // строим селект родительских категорий
            $this->setValue('parentArray', $this->_makeStandardArray());
            $this->setValue('active', true); // по умолчанию создавать активные стандарты

            $user = Shop::Get()->getUserService()->getUser();
            $cdate = date('Y-m-d H:i:s');
            $content = new XShopStandard();

            if ($this->getArgumentSecure('ok')) {

                if ($this->getArgumentSecure('content')) {
                    $text = $this->getArgumentSecure('content');
                } else {
                    $text = ' ';
                }
                $parentid = $this->getArgumentSecure('parentid');
                $active = $this->getArgumentSecure('active');

                $this->setValue('active', $active); // сохраняем результат, в случае error
                $this->setValue('text', $text); // сохраняем результат, в случае error
                $this->setValue('parentid', $parentid); // сохраняем результат, в случае error

                $content->setContent($text);
                $content->setCdate($cdate);
                $content->setCauthorid($user->getId());
                $content->setParentid($parentid);
                $content->setActive($active);

                if ($this->getArgumentSecure('name')) {
                    $name = $this->getArgument('name');
                } else {
                    $this->setValue('message', 'error');
                    return false;
                }
                $content->setName($name);
                $content->insert();
                $this->setValue('message', 'ok');

                // ссылка для редиректа после создания
                $linkRedirect = Engine::GetLinkMaker()->makeURLByContentIDParam('standard-tpl', $content->getId());
                $this->setValue('redirLink', $linkRedirect);
            }
        } catch (Exception $ge){

        }
    }

    public function makeStandardTree($rootID = 0) {
        $standard = $this->getStandardAll();
        $a = array();
        while ($x = $standard->getNext()) {
            $a[$x->getParentid()][] = $x;
        }

        return $this->_makeStandardTree($rootID, 0, $a);
    }

    public function getStandardAll() {
        $x = new XShopStandard();
        $x->setOrder('name', 'ASC');
        return $x;
    }

    private function _makeStandardArray() {
        // строим массив всех стандартов
        $standard = $this->makeStandardTree();
        $a = array();
        foreach ($standard as $x) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'level' => $x->getField('level'),
            );
        }
        return $a;
    }

    private function _makeStandardTree($parentID, $level, $standardArray) {
        $a = array();
        if (empty($standardArray[$parentID])) {
            return $a;
        }
        foreach ($standardArray[$parentID] as $x) {
            // хитро дописываем поле level
            $x->setField('level', $level);

            $a[] = $x;
            $childs = $this->_makeStandardTree($x->getId(), $level + 1, $standardArray);
            foreach ($childs as $y) {
                $a[] = $y;
            }
        }
        return $a;
    }

}