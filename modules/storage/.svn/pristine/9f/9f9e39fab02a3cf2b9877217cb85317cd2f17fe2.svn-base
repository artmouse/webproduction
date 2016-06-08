<?php
class storage_index extends Engine_Class {

    public function process() {
        // разрешены ли склады
        $allowStorage = Engine::Get()->getConfigFieldSecure('storage-status');
        if (!$allowStorage) return ;

        $table = new Shop_ContentTable(new Datasource_Storage(true));

        $table->removeField('code');

        /*$field = new Shop_ContentFieldToBasket('order', 'storage');
        $field->setName('Заказ');
        $field->setSortable(false);
        $table->addField($field);

        $field = new Shop_ContentFieldToTransfer('transfer');
        $field->setName('Выдача');
        $field->setSortable(false);
        $table->addField($field);*/

        $this->setValue('table', $table->render());

        $storagenames = StorageService::Get()->getStorageNamesArrayByUser(
        $this->getUser(),
        'read'
        );
        $this->setValue('storagenamesArray', $storagenames);

        $managers = Shop::getUserService()->getUsersAll();
        $managers->addWhere('level', 2, '>=');
        if ($managers->getCount() > 1) {
            $this->setValue('managersArray', $managers->toArray());
        }
    }

}