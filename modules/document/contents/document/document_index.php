<?php
class document_index extends Engine_Class {

    public function process() {
        $documents = DocumentService::Get()->getDocumentsAll($this->getUser());

        $block_documents = Engine::Get()->GetContentDriver()->getContent('shop-admin-document-table-block');
        $block_documents->setValue('documents', $documents);
        $this->setValue('table_block', $block_documents->render());
    }

}