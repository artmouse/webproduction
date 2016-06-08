<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Shop_CacheModifierTemplate
 *
 * @author root
 */
class Shop_CacheModifierTemplate extends Engine_ACacheModifier {
    public function modifyKey($key) {
        return $key.'-'.Engine::Get()->getConfigFieldSecure('shop-template');
    }
}
