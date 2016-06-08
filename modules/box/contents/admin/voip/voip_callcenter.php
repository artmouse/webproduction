<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Package
 */
class voip_callcenter extends Engine_Class {

	public function process() {
        PackageLoader::Get()->registerJSFile('/_js/SIPml-api.js');

        try {
            $config = Engine::Get()->getConfigField('project-box-sip-accounts');
            $myPhoneArray = $this->getUser()->getPhoneArray();

            foreach ($config as $number => $settings) {
            	if (in_array($number, $myPhoneArray)) {
            		$this->setValue('voipSettings', $settings);
            		break;
            	}
            }
        } catch (Exception $ge) {

        }
	}

}