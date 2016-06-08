<?php
class help_menu extends Engine_Class {

    public function process() {
        $pageArray = Shop_ModuleLoader::Get()->getHelpItemArray();
        $a = array();
        $b = array();
        $this->contentID = Engine::Get()->getRequest()->getContentID();

        foreach ($pageArray as $page) {
            $legArray = array();
            $file = file_get_contents($page['file']);
            if (preg_match_all('/[^(Смотрите также:)]<h2>(.+?)<\/h2>/ius', $file, $r)) {
                $k = 0;
                foreach ($r[1] as $index => $x) {           
                    $data = trim($r[1][$index]);
                    $data = strip_tags($data);
                    $legArray[] = array(
                        'name' => $data,
                        'id' => $k++,
                    );
                }
            }
            $newpage = array(
                'name' => $page['title'],
                'key' => $page['key'],
                'url' => '/doc/'.$page['key'],
                'parent' => $page['parent'],
                'sort' => $page['sort'],
                'selected' => ('help-'.$page['key'] == $this->contentID),
                'legArray' => $legArray
            );
            $a[$page['parent']][] = $page;

            if ($page['parent']) {
                $b[$page['parent']][] = $newpage;
            } else {
                $b[1][] = $newpage;
            }
        }

        // sorting chapters order by order using field 'sort' (SORT_ASC 0->100)
        foreach ($b[1] as $key => $item) {
            $sort[$key] = $item['sort'];
        }
        array_multisort($sort, SORT_ASC, $b[1]);

        $this->setValue('newMenuArray', $b);
        $this->setValue('menuArray', $this->_makeMenuArray($a));
    }

    private function _makeMenuArray($pageArray, $parent = '', $menuArray = array(), $level = 0) {
        if (!isset($pageArray[$parent])) {
            return $menuArray;
        }

        $a = $pageArray[$parent];

        foreach ($a as $page) {
            $b = array();

            $pageKey = $page['key'];

            $b['name'] = $page['title'];
            $b['url'] = '/doc/'.$pageKey;
            $b['level'] = $level;
            $b['parent'] = $page['parent'];
            $b['selected'] = ('help-'.$pageKey == $this->contentID);

            $menuArray[$pageKey] = $b;
            $menuArray = $this->_makeMenuArray($pageArray, $page['key'], $menuArray, $level + 1);
        }

        return $menuArray;
    }

    protected $contentID = false;
}