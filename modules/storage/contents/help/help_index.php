<?php
class help_index extends Engine_Class {

    public function process() {

        $f = 'page1.html';

        if ($this->getArgumentSecure('file')) {
            $f = $this->getArgumentSecure('file');
        }
        $path = PROJECT_PATH."modules/storage/docs/usermanual/$f";

        if (!file_exists($path) || is_dir($path)) {
            $path = PROJECT_PATH."modules/storage/docs/usermanual/page1.html";
        }
        $line = file_get_contents($path, true);
        $this->setValue('text', $line);

        $this->_xml = simplexml_load_string(file_get_contents(
        PackageLoader::Get()->getProjectPath().'modules/storage/contents/help/help.xml'
        ));
        
        $this->setValue('menuArray', $this->_makeMenuArray(0, $f));
    }

    private function _makeMenuArray($parendID, $select){

        $xml = $this->_xml;
        $a = array();
        foreach($xml->item as $item){

            $name = trim($item->name.'');
            $url = trim($item->url.'');
            $color = trim($item->color.'');
            $pid = trim($item->parentid.'');
            $id = trim($item->id.'');

            if($pid == $parendID){
                if($url == $select){
                    Engine::GetHTMLHead()->setTitle($name);
                }
                $a[] = array(
                    'name' => $name,
                    'url' => '/admin/shop/storage/help/'.$url.'/',
                    'color' => $color,
                    'selected' => $url == $select ? true : false,
                    'childsArray' => $this->_makeMenuArray($id, $select)
                );
            }
        }
        return $a;

    }

    private $_xml = false;
}