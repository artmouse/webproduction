<?php
class document_print extends Engine_Class {

    public function process() {
        try {
            $user = $this->getUser();

            $document = DocumentService::Get()->getDocumentByID(
                $this->getArgument('id')
            );

            if (!DocumentService::Get()->isDocumentViewAllowed($document, $user)) {
                throw new ServiceUtils_Exception();
            }

            $this->_document = $document;

            $content = preg_replace_callback("/\[(.+?)\]/ius", array($this, '_callback'), $document->getContent());

            $this->setValue('content', $content);
            $this->setValue(
                'onebox_text', 
                Shop::Get()->getSettingsService()->getSettingValue('show-onebox-info-print')
            );           
            
        } catch (Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

    private function _callback($x) {
        $name = $x[1];

        $tmp = new XShopDocumentFieldValue();
        $tmp->setDocumentid($this->_document->getId());
        $tmp->setName($name);
        $tmp->select();
        $value = $tmp->getValue();

        return $value;
    }

    private $_document;

}