<?php
class storage_stocktaking extends Engine_Class {

    public function process() {
        $cuser = $this->getUser();

        // определяем, выбран ли склад, с которого будут перемещаться товары
        $storageName = false;

        try {
            $storageName = StorageNameService::Get()->getStorageNameByID(
            $this->getControlValue('storagefromid')
            );
        } catch (Exception $e) {}

        // товары в корзине перемещения
        $baskets = StorageStocktakingService::Get()->getStocktakingBaskets();
        while ($basket = $baskets->getNext()) {
            try {
                $storageName = $basket->getStorageName();
            } catch (Exception $e) {}
        }

        if ($storageName) {
            $this->setControlValue('storagefromid', $storageName->getId());
            $this->setValue('storagefromname', $storageName->getName());
        }

        // таблица товаров в корзине
        $block = Engine::GetContentDriver()->getContent('shop-admin-storage-stocktaking-table-block');
        $this->setValue('basketTable', $block->render());

        // склады
        $storageNames = StorageNameService::Get()->getStorageNamesForTransfers();
        $this->setValue('storagesfromArray', $storageNames->toArray());

        // список категорий
        $category = Shop::Get()->getShopService()->makeCategoryTree();
        $a = array();
        foreach ($category as $x) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            'hidden' => $x->getHidden(),
            'level' => $x->getField('level'),
            'selected' => $x->getId() == $this->getArgumentSecure('categoryid'),
            'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $x->getId())),
            'parentid' => $x->getParentid(),
            );
        }
        $this->setValue('categoryArray', $a);

        // количество товара по умолчанию
        $this->setControlValue('count', 1);
    }

}