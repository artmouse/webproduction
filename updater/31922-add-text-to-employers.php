<?php

require_once(dirname(__FILE__) . '/../packages/Engine/include.2.6.php');

$emploeyrs = new XUser();
$emploeyrs->setEmployer(1);
$emploeyrs->setOrder('id');

while ($e = $emploeyrs->getNext()) {
    $welcometext = new XWelcomeText();
    $welcometext->setUserid($e->getId());
    $welcometext->filterContent('', '!=');
    
    if (!$welcometext->select()) {
        $welcometext->setContent('<h2>Твой БИЗНЕС</h2><h2>Твои ПРАВИЛА</h2><h2>Твой OneBox</h2>');
        $welcometext->insert();
    }
}