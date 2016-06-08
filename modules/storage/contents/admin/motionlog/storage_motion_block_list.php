<?php
class storage_motion_block_list extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            // таблица
            $table = new Shop_ContentTable(new Datasource_Storage_Motionlog(
            false,
            false,
            false,
            false,
            false,
            false,
            false,
            $this->getValue('orderid'),
            $this->getValue('productid')
            ));

            $table->removeField('id');
            $table->removeField('return');
            $this->setValue('table', $table->render());

        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}