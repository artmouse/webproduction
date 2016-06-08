<?php
class manager_index extends Engine_Class {

    public function process() {
        if ($this->getArgumentSecure('ok')) {
            $url = $this->getArgumentSecure('url');
            $page = file_get_contents($url);
            //$page = $this->replace_lincks($page);
            $page = preg_replace("!<a(.*?)>(.*?)</a>!si","<a href='#'>\\2</a>",$page);
            $page = preg_replace("/(onclick=\".+?\")/","data-rel='pizda'",$page);

            $this->setValue('page', $page);
        }
    }

    private function replace_lincks ($page) {
        preg_match_all('/<a(.*?)href="(.*?)"(.*?)>/', $page, $matches);
        $urls = $matches[1];
        for ($i = 0; $i < count($urls); $i++) {
            $page = str_replace($urls[$i],"<a href='javascript: void(0);'>", $page);
        }
        return $page;
    }

}