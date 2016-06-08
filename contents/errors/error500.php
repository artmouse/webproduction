<?php

class error500 extends Engine_Class {

    public function process() {
        Engine::Get()->getResponse()->setHTTPStatus('500 Internal Server Error');
    }

}