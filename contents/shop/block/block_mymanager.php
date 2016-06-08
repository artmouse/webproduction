<?php
class block_mymanager extends Engine_Class {

    public function process() {
        try {
            $manager = $this->getUser()->getManager();
            if (!$manager->getEmployer()) {
            	throw new ServiceUtils_Exception();
            }

            $this->setValue('showmanager', true);
            $this->setValue('managername', $manager->getName());
            $this->setValue('managerphone', $manager->getPhone());
            $this->setValue('manageremail', $manager->getEmail());
            $this->setValue('manageravatar', $manager->makeImageThumb(50, 50));
        } catch (Exception $managerEx) {

        }
    }

}