<?php
class products_in_list extends Engine_Class {

    public function process() {
        $this->setValue('useCode1c', Shop::Get()->getSettingsService()->getSettingValue('use-code-1c'));
        // добавление кодов
        if ($this->getControlValue('ok')) {
            try {
                $list = Shop::Get()->getShopService()->getProductsListByID(
                $this->getArgumentSecure('l')
                );

                // удалить товары из списка
                $delete = $this->getArgumentSecure('delete');
                if ($delete) {
                    Shop::Get()->getShopService()->deleteProductsFromList(
                    $list,
                    $delete
                    );
                }

                // добавить товары список
                $add = $this->getArgumentSecure('codes');
                if ($add) {
                    Shop::Get()->getShopService()->addProductsToList(
                    $list,
                    $add
                    );
                }

                $this->setValue('message', 'ok');
            } catch (Exception $te) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $te;
                }

                $this->setValue('message', 'error');
            }
        }

        // отображение товаров в выбранном списке
        try {
            $listID = $this->getArgumentSecure('l');
            $list = Shop::Get()->getShopService()->getProductsListByID($listID);
            $this->setValue('name', $list->makeName());

            $table = new Shop_ContentTable(new Datasource_ProductsInList($list));

            if (!$list->getLogicclass()) {
                $field = new Forms_ContentFieldCheckboxKey('checkbox');
                $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_act'));
                $table->addField($field);
                $this->setValue('logicclass', true);
            }

            $this->setValue('table', $table->render());
        } catch (Exception $listEx) {

        }
        // получение всех списков
        $list = Shop::Get()->getShopService()->getProductsListAll();
        // $list->setHidden(0);


        // stepper
        $onPage = 30;
        $p = $this->getArgumentSecure('p');

        // количество товаров: всего
        $cnt = $list->getCount();

        if (!$list->getLimitCount()) {
            $list->setLimit($p * $onPage, $onPage);
        }

        $a = array();
        while ($l = $list->getNext()) {
            $info = array();
            $info['id'] = $l->getId();
            $info['name'] = $l->makeName();
            $info['linkkey'] = htmlspecialchars($l->getLinkkey());
            $a[] = $info;
        }
        $this->setValue('listArray', $a);

        $ar = array();
        $ar = $this->_pages($p, $onPage, $cnt);
        $this->setValue('pagesArray', $ar['pagesArray']);
        if (isset($ar['urlnext'])) {
            $this->setValue('urlnext', $ar['urlnext']);
        }
        if (isset($ar['urlprev'])) {
            $this->setValue('urlprev', $ar['urlprev']);
        }
        if (isset($ar['hellip'])) {
            $this->setValue('hellip', $ar['hellip']);
        }
    }

    private function _pages($page, $onPage, $count) {
        $assignsArray = array();

        $a = array();
        $cnt = ceil($count / $onPage);

        $stop = $page + 3;
        $start = $page - 3;

        if ($stop > $cnt) {
            $stop = $cnt;
            $start = $stop - 5;
        }

        if ($start < 0) {
            $start = 0;
            $stop = $start + 5;
        }
        if ($stop > $cnt) {
            $stop = $cnt;
        }

        for ($j = $start; $j < $stop; $j++) {
            $a[] = array(
                'name' => ($j + 1),
                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('p' => $j)),
                'selected' => $j == $page,
            );
        }

        $assignsArray['pagesArray'] = $a;

        if ($page + 1 < $cnt) {
            $assignsArray['urlnext'] = Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('p' => $page + 1));
        }

        if ($page - 1 >= 0) {
            $assignsArray['urlprev'] = Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('p' => $page - 1));
        }

        if ($stop - $start > 0) {
            $assignsArray['hellip'] = true;
        }

        return $assignsArray;
    }

}