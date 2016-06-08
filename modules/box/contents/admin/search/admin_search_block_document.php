<?php
class admin_search_block_document extends Engine_Class {

    public function process() {
        try {
            $query = $this->getValue('query');
            $limit = $this->getValue('limit');

            $documents = DocumentService::Get()->searchDocuments($query);
            $documents->setLimitCount($limit);

            $documentArray = array();
            while ($document = $documents->getNext()) {
                $documentArray[] = array(
                'id' => $document->getId(),
                'name' => $document->makeName(),
                'url' => $document->makeURLEdit()
                );
            }

            $this->setValue('documentArray', $documentArray);
        } catch (Exception $e) {

        }
    }

}