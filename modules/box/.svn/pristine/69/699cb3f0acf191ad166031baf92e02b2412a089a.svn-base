<?php
/**
 * OneBox
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

/**
 * Отконвертировать старые комментарии в новый формат comment/change/notify
 */

$comments = new CommentsAPI_XComment();
$comments->addWhere('key', 'shop-order-%', 'LIKE');
$comments->setOrder('id', 'DESC');
while ($x = $comments->getNext()) {
    print_r($x->getValues());

    if (preg_match("/^Создана задача/ius", $x->getContent())) {
        $x->setType('change');
        $x->update();
    }

    if (preg_match("/^Обновлена задача/ius", $x->getContent())) {
        $x->delete();
        continue;
    }

    if (preg_match("/^Статус обновлен на/ius", $x->getContent())) {
        $x->setType('change');
        $x->update();
    }

    if ($x->getId_user() == -1) {
        $x->setType('notify');
        $x->update();
    }
}

print "\n\ndone.\n\n";