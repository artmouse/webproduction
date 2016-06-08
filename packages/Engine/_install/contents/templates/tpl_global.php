<?php
class tpl_global extends SClass {

    public function process() {
        $this->setValue('title', Engine::GetHTMLHead()->getTitle());
        $this->setValue('engine_includes', Engine::GetHTMLHead()->render());
    }

}