<?php

$contentErrorArray = array();

$contentErrorArray['supplier_workflow'] = 'Бизнес-процесс поставщика не найден.';
$contentErrorArray['parent-empty'] = 'Проект не найден.';

$contentErrorArray['process_recursion_add_issue'] = 'Обнаружена рекурсия.
Проверьте действия статуса, на предмет создания новых задач.';

Shop_ContentErrorHandler::Get()->addErrorKeyArray($contentErrorArray);