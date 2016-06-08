<?php
class document_pdf extends Engine_Class {

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

            $html = preg_replace_callback("/\[(.+?)\]/ius", array($this, '_callback'), $document->getContent());
            // use absolute links (like http://my.host/image.gif).
            if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                $h = 'https://';
            } else {
                $h = 'http://';
            } 
            $html =  preg_replace('/\/media\//', $h . Engine::GetURLParser()->getHost() . '/media/', $html);
            $fileHTML = PackageLoader::Get()->getProjectPath().'/media/tmp/'.$document->getId().'.html';
            $filePDF = PackageLoader::Get()->getProjectPath().'/media/document/'.$document->getId().'.pdf';

            if (!substr_count($html, '<body>')) {
                $tmp = '<!DOCTYPE html><html><head><meta
                    http-equiv="content-type" content="text/html; charset=UTF-8" />';
                $tmp .= '</head><body>';
                $tmp .= $html;
                if (Shop::Get()->getSettingsService()->getSettingValue('show-onebox-info-print')) {
                    $tmp .= '<br/><br/>';
                    $tmp .= '<small>Документ автоматически сформирован в системе OneBox - больше чем CRM и ERP</small>';
                }
                $tmp .= '</body></html>';

                $html = $tmp;
                unset($tmp);
            } else {
                if (Shop::Get()->getSettingsService()->getSettingValue('show-onebox-info-print')) {
                    $tmp = '<br/><br/>';
                    $tmp .= 
                    '<small>Документ автоматически сформирован в системе OneBox - больше чем CRM и ERP</small></body>';
                    $html = str_replace('</body>', $tmp, $html);
                }                
            }

            @unlink($filePDF);

            file_put_contents($fileHTML, $html, LOCK_EX);

            // @todo: auto skip
            if (1 || !file_exists($filePDF)) {
                PackageLoader::Get()->import('PDF');
                PDF_Container::Get()->html2pdf_extenal($fileHTML, $filePDF);
            }

            header('Content-type: application/pdf');
            readfile($filePDF);
            exit();
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