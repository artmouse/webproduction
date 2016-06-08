<?php
class shop_news extends Engine_Class {

    public function process() {
        $pageid = $this->getValue('pageid');
        $onPage = 10;
        $p = $this->getArgumentSecure('page');
        if (!$p) {
            $p = 0;
        }
        // новости
        $news = Shop::Get()->getNewsService()->getNewsAll();
        $news->setHidden(0);
        if ($pageid > 0) {
            $news->setPageid($pageid);
        }

        $count = $news->getCount();

        $news->setLimit($p * $onPage, $onPage);

        $a = array();
        while ($x = $news->getNext()) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                'contentPreview' => $x->getContentpreview(),
                'image' => $x->makeImageThumb(400, false, 'prop'),
                'date' => DateTime_Formatter::DateTimePhonetic($x->getCdate()),
                'url' => $x->makeURL(),
            );
        }
        $this->setValue('newsArray', $a);

        $ar = $this->_pages($p, $onPage, $count);
        $a = array();
        $a = $ar['pagesArray'];
        $this->setValue('pagesArray', $a);
        if (isset($ar['urlnext'])) {
            $this->setValue('urlnext', $ar['urlnext']);
        }
        if (isset($ar['all'])) {
            $this->setValue('allpages', $ar['all']);
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

        for ($j = $start; $j < $cnt; $j++) {
            $a[] = array(
                'name' => ($j + 1),
                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('page' => $j)),
                'selected' => $j == $page,
                'visible' => $j > $stop? false:true,
            );
        }

        $assignsArray['pagesArray'] = $a;

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

        /*
            $assignsArray['all'] = $filter ? $this->_makeFiltersUrl('p=', $fullUrl, 'p=all') :
            $currentURL.'/filter_p=all';
            Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('p' => 'all'));
        */


        if ($stop - $start > 0) {
            $assignsArray['hellip'] = true;
        }

        return $assignsArray;
    }

}