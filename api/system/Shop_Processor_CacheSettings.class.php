<?php

class Shop_Processor_CacheSettings {

    public function process() {
        try {
            Engine::GetCache()->removeData('setting-keys');
        } catch (Exception $exCache) {

        }
    }

}