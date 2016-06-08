<?php
class standard_edit extends Engine_Class {

    public function process() {
        $user = Shop::Get()->getUserService()->getUser();
        $link = $this->getArgumentSecure('id');
        $cdate = date('Y-m-d H:i:s');
        $content = new XShopStandard($link);
        $parentId = $content->getParentid();
        $this->setValue('currentStandard', $link);

        $this->setValue('parentArray', $this->_makeStandardArray());

        if ($this->getArgumentSecure('ok')) {

            if ($this->getArgumentSecure('content')) {
                $text = $this->getArgumentSecure('content');
            } else {
                $text = ' ';
            }
            $active = $this->getArgumentSecure('active');
            $parentid = $this->getArgumentSecure('parentid');

            $this->setValue('text', $text); // сохраняем результат, в случае error
            $this->setValue('parentid', $parentid); // сохраняем результат, в случае error
            $this->setValue('active', $active); // сохраняем результат, в случае error

            $content->setContent($text);
            $content->setMdate($cdate);
            $content->setMauthorid($user->getId());
            $content->setParentid($parentid);
            $content->setActive($active);
            if ($this->getArgumentSecure('name')) {
                $name = $this->getArgument('name');
            } else {
                $this->setValue('message', 'error');
                return false;
            }
            $content->setName($name);
            $content->update();

            // сохраняем историю изменений
            $log = new XShopStandardLog();
            $log->setName($name);
            $log->setContent($text);
            $log->setStandardid($link);
            $log->setCdate($cdate);
            $log->setUserid($user->getId());
            $log->insert();

            $this->setValue('message', 'ok');
        }

        if ($this->getArgumentSecure('delete')) {

            // если у стандарта есть дочерние
            $standard = $this->getStandardAll();
            $standard->filterParentid($link);
            while ($x = $standard->getNext()) {
                $x->setParentid($parentId);
                $x->update();
            }
            $content->delete();
            $this->setValue('message', 'delete');

            // ссылка для редиректа после удаления
            $linkRedirectAll = Engine::GetLinkMaker()->makeURLByContentID('standard-tpl');
            $this->setValue('redirLinkAll', $linkRedirectAll);
        }

        $parentCategory = $content->getParentid();
        $this->setValue('parentCategory', $parentCategory);

        $this->setValue('control_text', $content->getContent());
        $this->setValue('control_name', $content->getName());
        $this->setValue('active', $content->getActive());
        $this->setValue('content', $content->getContent());
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

    /**
     * Строим массив всех категорий
     *
     * @return array
     */
    private function _makeStandardArray($id = false) {
        // строим массив всех стандартов
        $standard = $this->makeStandardTree($id);
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