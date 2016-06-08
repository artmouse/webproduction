<?php
class maps_index extends Engine_Class {
    
    /**
     * *
     * @return ShopOrder
     */
    private function _getIssues() {
        return $this->getValue('issue');
    }
    
    public function process() {
    
        PackageLoader::Get()->registerJSFile('//api-maps.yandex.ru/2.0-stable/?load=package.full&lang=ru-RU');
        PackageLoader::Get()->registerJSFile('/_js/yandex.maps.api.js');
        
        $issues = $this->_getIssues();
        $issues->setLimit($this->getArgumentSecure('page') * 100, 100);
        
        $issues->unsetField('dateclosed');
        
              
        $adressArrray = array();

        while ($i = $issues->getNext()) {
            try {
                if ($i->getClientAddress()) {
                    $adressArrray[] = $i->getClientAddress(); 
                } else {
                    $adressArrray[] = $i->getClient()->getAddress();
                } 
            } catch (Exception $ex) {
                
            }
             
        }
        $this->setValue('addressArray', json_encode($adressArrray));
        
        $onpage = 100;
        $page = Engine::GetURLParser()->getArgumentSecure('page');
        $this->setValue('pagesArray', $this->_pages($page, $onpage, $issues->getCount()));
        
        $issues->setLimitCount($onpage);
        $issues->setLimitFrom($page * $onpage);
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

}