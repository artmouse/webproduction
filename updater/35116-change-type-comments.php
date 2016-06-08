<?php

require_once(dirname(__FILE__) . '/../packages/Engine/include.2.6.php');

$comment = new CommentsAPI_XComment();
$comment->addWhereQuery("content LIKE '%документ #%'");

while ($x = $comment->getNext()) {
    $x->setType('document');
    $x->update();
}

print "\n\ndone\n\n";