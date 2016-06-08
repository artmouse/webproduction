<?php
class doc_editor_tpl extends Engine_Class {

    public function process() {
        $pageArray = Shop_ModuleLoader::Get()->getHelpItemArray();
        $a = array();
        $b = array();

        $this->contentID = Engine::Get()->GetURLParser()->getCurrentURL();

        foreach ($pageArray as $page) {
            $newpage = array(
                'name' => $page['title'],
                'key' => $page['key'],
                'url' => '/doc-editor/'.$page['key'],
                'parent' => $page['parent'],
                'sort' => $page['sort'],
                'selected' => ('/doc-editor/'.$page['key'] == $this->contentID)
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
            $b['selected'] = ('/doc-editor/'.$pageKey == $this->contentID);

            $menuArray[$pageKey] = $b;
            $menuArray = $this->_makeMenuArray($pageArray, $page['key'], $menuArray, $level + 1);
        }

        return $menuArray;
    }
    
    protected $contentID = false;
}