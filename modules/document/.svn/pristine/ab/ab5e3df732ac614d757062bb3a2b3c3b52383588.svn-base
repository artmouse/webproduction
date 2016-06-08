<?php
class document_fieldeditor extends Engine_Class {

    public function process() {
        try {
            $document = DocumentService::Get()->getDocumentByID(
                $this->getArgument('id')
            );

            $this->_document = $document;

            //Engine::Get()->enableErrorReporting();

            $content = preg_replace_callback("/\[(.+?)\]/ius", array($this, '_callback'), $document->getContent());

            print $content;
            exit();
        } catch (Exception $e) {
            Engine::getRequest()->setContentNotFound();
        }
    }

    private function _callback($x) {
        $name = $x[1];

        $tmp = new XShopDocumentFieldValue();
        $tmp->setDocumentid($this->_document->getId());
        $tmp->setName($name);
        $tmp->select();

        return '<input type="text" name="documentfield'.$tmp->getId().'" value="'.
               $tmp->getValue().'" placeholder="'.$name.'">';
    }

    private $_document;

}