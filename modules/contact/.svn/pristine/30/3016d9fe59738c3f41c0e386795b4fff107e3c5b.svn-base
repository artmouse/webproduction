<?php

class contact_list_mode_maps extends Engine_Class {

    public function process() {
        $adressArrray = array();
        $users = $this->_getUsers();
        $users->setLimit($this->getArgumentSecure('page') * 100, 100);
        $users->filterAddress('', '!=');
        while ($x = $users->getNext()) {
            $adressArrray[] = $x->getAddress();
            $usersName[] = $x->getName();
        }
        $this->setValue('addressArray', json_encode($adressArrray));
        $this->setValue('usersName', json_encode($usersName));
        
        $onpage = 100;
        $page = Engine::GetURLParser()->getArgumentSecure('page');
        $this->setValue('pagesArray', $this->_pages($page, $onpage, $users->getCount()));
        
        $users->setLimitCount($onpage);
        $users->setLimitFrom($page * $onpage);
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
                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('page' => $j)),
                'selected' => $j == $page,
            );
        }

        $assignsArray['pagesArray'] = $a;

        // текущая страница
        $assignsArray['pageCurrent'] = $page;

        if ($page + 1 < $cnt) {
            $assignsArray['urlnext'] = Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(
                array('page' => $page + 1)
            );
        }

        if ($page - 1 >= 0) {
            $assignsArray['urlprev'] = Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(
                array('page' => $page - 1)
            );
        }

        if ($stop - $start > 0) {
            $assignsArray['hellip'] = true;
        }

        return $assignsArray;
    }
    
    private function _getUsers() {
        return $this->getValue('datasource')->getSQLObject();
    }
}