<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$languagesArray = array(
    'ukr' => 'UA',
    'ru' => 'RU',
    'eng' => 'EN',
);

foreach ($languagesArray as $key => $name) {
    $document = DocumentService::Get()->getDocumentTemplatesAll();
    $document->setKey('order-act-'.$key);
    if ($document->select()) {
        $document->setContent('file:/media/mail-templates/shop-document-akt-'.$key.'.html');
        $document->update();
    }

    $document = DocumentService::Get()->getDocumentTemplatesAll();
    $document->setKey('invoice-'.$key);
    if ($document->select()) {
        $document->setContent('file:/media/mail-templates/shop-document-invoice-'.$key.'.html');
        $document->update();
    }

    $document = DocumentService::Get()->getDocumentTemplatesAll();
    $document->setKey('salebill-'.$key);
    if ($document->select()) {
        $document->setContent('file:/media/mail-templates/shop-document-salebill-'.$key.'.html');
        $document->update();
    }

}

print "\n\ndone.\n\n";