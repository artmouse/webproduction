<?php
class user_tile extends Engine_Class {

    public function process() {
        $users = $this->_getUsers();

        $onpage = 150;
        $page = Engine::GetURLParser()->getArgumentSecure('page');
        $this->setValue('pagesArray', $this->_pages($page, $onpage, $users->getCount()));

        $users->setLimitCount($onpage);
        $users->setLimitFrom($page*$onpage);
        $userArray = array();
        while ($x = $users->getNext() ) {
            try {
                if ($x->getTypesex() == 'company') {
                    $companyObject = $x;
                } else {
                    $companyObject = Shop::Get()->getShopService()->getCompanyByName($x->getCompany());
                }
                $companyUrl = $companyObject->makeURLEdit();

            } catch (Exception $e) {
                $companyUrl = $x->makeURLEdit();
            }
            $userArray[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(false, 'lfm'),
                'login' => $x->getLogin(),
                'url' => $x->makeURLEdit(),
                'company' => htmlspecialchars($x->getCompany()),
                'companyUrl' => $companyUrl,
                'post' => $x->getPost(),
                'image' => $x->makeImageThumb(),
                'phone' => $x->getPhone(),
                'email' => $x->getEmail()
            );
        }

        $this->setValue('userArray', $userArray);
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

    /**
     * Метод-обертка для типизации
     *
     * @return User
     */
    private function _getUsers() {
        return $this->getValue('users');
    }

}