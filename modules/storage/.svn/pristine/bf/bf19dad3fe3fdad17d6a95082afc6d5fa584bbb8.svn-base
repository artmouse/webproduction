<?php
class logicblock_stepper extends Engine_Class {

    public function process() {
        $page = $this->getValue('page');
        $onPage = $this->getValue('onPage');
        $count = $this->getValue('count');

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

        $this->setValue('pagesArray', $a);

        if ($page + 1 < $cnt) {
            $this->setValue('urlnext', Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('page' => $page + 1)));
        }

        if ($page - 1 >= 0) {
            $this->setValue('urlprev', Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('page' => $page - 1)));
        }

        if ($stop - $start > 0) {
            $this->setValue('hellip', true);
        }
    }

}