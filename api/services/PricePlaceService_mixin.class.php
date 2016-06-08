<?php

include(PackageLoader::Get()->getProjectPath() . '/api/services/PricePlaceService.php');

class PricePlaceService_mixin extends PricePlaceService {

    public function process() {
        parent::processExports();
        
    }



}