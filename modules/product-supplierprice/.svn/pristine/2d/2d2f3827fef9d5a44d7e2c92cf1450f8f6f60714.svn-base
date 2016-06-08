<?php
class products_supplier_import_history extends Engine_Class {

    public function process() {
        // таблица со списком очереди загрузок
        $statusTable = Engine::GetContentDriver()->getContent('shop-admin-status-supplier-import');
        // только обработанные
        $statusTable->setValue('processed', false);
        $this->setValue('statusTable', $statusTable->render());
    }

}