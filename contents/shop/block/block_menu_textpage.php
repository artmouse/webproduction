<?php
class block_menu_textpage extends Engine_Class {

    public function process() {
        // меню магазина: страницы
        $this->setValue('textpageArray', $this->_makeTextpageArray());
        $this->setValue('urlformainpage',Engine::Get()->getConfigField('project-host'));
    }

    /**
     * @param int $parentID
     * @return array
     */
    private function _makeTextpageArray($parentID = 0) {
        // загружаем все текстовые страницы в один список
        $pageArray = Shop::Get()->getTextPageService()->getTextPageArray();
        $a = array();
        foreach ($pageArray as $x) {
            if ($x->getHidden()) {
                continue;
            }

            $selected = false;
            if (Engine::Get()->getRequest()->getContentID() == 'shop-page') {
                $selected = ($x->getId() == $this->getArgumentSecure('id'));
            }

            $a[$x->getParentid()][] = array(
            'id' => $x->getId(),
            'parentid' => $x->getParentid(),
            'btnName' => $x->getBtnname(),
            'name' => $x->makeName(),
            'image' => $x->makeImage(),
            'url' => $x->makeURL(),
            'selected' => $selected,
            );
        }

        // переделываем список на двухуровневый
        $b = array();
        if (isset($a[0])) {
            foreach ($a[0] as $x) {
                $x['childArray'] = @$a[$x['id']];
                $b[] = $x;
            }
        }

        return $b;
    }

}