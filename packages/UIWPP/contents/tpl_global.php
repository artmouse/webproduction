<?php
class wpp_tpl_global extends Engine_Class {

    public function process() {
        $this->setValue('title', Engine::GetHTMLHead()->getTitle());
        $this->setValue('year', date('Y'));
        $this->setValue('engine_includes', Engine::GetHTMLHead()->render());

        $favicon = $this->getValue('favicon');
        if (!$favicon) {
        	$favicon = str_replace(PROJECT_PATH, '/', dirname(__FILE__).'/../media/wpp-favicon.gif');
        }
        $this->setValue('favicon', $favicon);
    }

}