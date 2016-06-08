<?php
class document_download extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $document = DocumentService::Get()->getDocumentByID(
            $this->getArgument('id')
            );

            if (!DocumentService::Get()->isDocumentEditAllowed($document, $cuser)) {
                throw new ServiceUtils_Exception();
            }

            if ($this->getArgumentSecure('target') == 'scan') {
                $filePath = $document->makeURLFile();
                $fileName = $document->getFile();
            } else {
                $filePath = $document->makeURLFileOriginal();
                $fileName = $document->getFileoriginal();
            }

            if (!$filePath) {
                exit();
            }

            $filePath = PROJECT_PATH.$filePath;

            $size = @filesize($filePath);
            $info = @pathinfo($filePath);

            if (isset($info['extension'])) {
                $fileName = StringUtils_Transliterate::TransliterateRuToEn($document->makeName());
                $fileName = preg_replace("/([^0-9a-z\.\-\_])/is", '-', $fileName);
                $fileName = preg_replace('/([\-]{2,})/ius', '-', $fileName);
                $fileName .= $document->getId().'.'.$info['extension'];
            }

            header('Content-Type: application/octet-stream');
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename='.$fileName);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            if ($size) {
                header('Content-Length: '.$size);
            }
            readfile($filePath);

            exit();
        } catch (Exception $e) {
            exit();
        }
    }

}