<?php

class Shop_Processor_CacheContents {

    public function process() {
        try {
            Engine::GetCache()->removeData(Engine::Get()->getProjectHost().'contents-data');
        } catch (Exception $exCache) {

        }

    }

}