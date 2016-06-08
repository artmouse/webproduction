<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class DocumentService extends ServiceUtils_AbstractService {

    /**
     * Получить документ по id
     *
     * @param int $id
     *
     * @return ShopDocument
     *
     * @throws ServiceUtils_Exception
     */
    public function getDocumentByID($id) {
        return $this->getObjectByID($id, 'ShopDocument');
    }

    /**
     * Получить все документы
     *
     * @param User $user
     *
     * @return ShopDocument
     */
    public function getDocumentsAll($user = false) {
        $x = new ShopDocument();
        $x->setDeleted(0);
        $x->setOrder('cdate', 'DESC');

        if ($user) {
            $userID = $user->getId();
            // накладываем ACL
            if ($user->getLevel() >= 3) {
                return $x;
            }

            if ($user->isAllowed('documents-all-view')) {
                return $x;
            }

            // фильтр по менеджеру заказа
            if ($user->isDenied('document-manager-all-view')) {
                $managers = Shop::Get()->getUserService()->getUsersManagers();
                $managerIDArray = array($userID); // свои видно всегда
                while ($m = $managers->getNext()) {
                    if ($user->isAllowed('document-manager-'.$m->getId().'-view')) {
                        $managerIDArray[] = $m->getId();
                    }
                }

                if ($managerIDArray) {
                    $x->filterUserid($managerIDArray);
                }
            }

            // фильтр по шаблону
            if ($user->isDenied('document-template-all-view')) {
                $documents = DocumentService::Get()->getDocumentTemplatesActive();
                $statusIDs = array();
                while ($s = $documents->getNext()) {
                    if ($user->isAllowed('document-template-'.$s->getId().'-view')) {
                        $statusIDs[] = $s->getId();
                    }
                }

                if ($statusIDs) {
                    $x->filterTemplateid($statusIDs);
                }

                //$whereArray[] = '(shoporder.statusid IN ('.implode(', ', $statusIDs).'))';
            }

        }

        return $x;
    }

    /**
     * Получить все документы
     *
     * @deprecated
     *
     * @see getDocumentsAll
     *
     * @return ShopDocument
     */
    public function getDocumentsActive() {
        return $this->getDocumentsAll();
    }

    /**
     * Поиск документов
     *
     * @param string $query
     *
     * @return ShopDocument
     */
    public function searchDocuments($query) {
        $query = trim($query);
        if (strlen($query) < 3 && !is_numeric($query)) {
            throw new ServiceUtils_Exception();
        }

        $documents = $this->getDocumentsAll();
        $connection = $documents->getConnectionDatabase();

        // перестановки всех слов
        $a = array();
        if (preg_match_all("/([\.\d\pL]+)/ius", $query, $r)) {
            foreach ($r[1] as $part) {
                $a[] = $connection->escapeString($part);
            }
        }

        if (!$a) {
            throw new ServiceUtils_Exception();
        }

        foreach ($a as $part) {
            $w = array();

            if (is_numeric($part)) {
                $w[] = $documents->getTablename().".id = '$part'";
            }

            $w[] = $documents->getTablename().".number LIKE '%$part%'";
            $w[] = $documents->getTablename().".name LIKE '%$part%'";
            $w[] = $documents->getTablename().".content LIKE '%$part%'";

            $documents->addWhereQuery("(".implode(' OR ', $w).")");
        }

        return $documents;
    }

    /**
     * Получить документы по ключу
     *
     * @param string $key
     * @param User $user
     *
     * @return ShopDocument
     */
    public function getDocumentsByLinkKey($key, $user = false) {
        $x = $this->getDocumentsAll();
        $x->setLinkkey($key);

        if ($user) {
            if ($user->getLevel() >= 3) {
                return $x;
            }

            if ($user->isAllowed('documents-all-view')) {
                return $x;
            }

            $managers = Shop::Get()->getUserService()->getUsersManagers();
            $managerIDArray = array(-1);
            $managerIDArray[] = $user->getId(); // свои видно всегда
            while ($m = $managers->getNext()) {
                if ($user->isAllowed('document-manager-'.$m->getId().'-view')) {
                    $managerIDArray[] = $m->getId();
                }
            }
            $x->addWhereArray($managerIDArray, 'userid');
        }

        return $x;
    }

    /**
     * Может ли пользователь просматривать документ
     *
     * @param ShopDocument $document
     * @param User $user
     *
     * @return bool
     */
    public function isDocumentViewAllowed(ShopDocument $document, User $user) {
        if ($user->isAllowed('documents-all-view')) {
            return true;
        }

        if ($user->isAllowed('document-template-all-view')) {
            return true;
        }

        if ($user->isAllowed('document-manager-'.$document->getUserid().'-view')) {
            return true;
        }

        if ($user->isAllowed('document-template-'.$document->getTemplateid().'-view')) {
            return true;
        }

        return false;
    }

    /**
     * Может ли пользователь редактировать документ
     *
     * @param ShopDocument $document
     * @param User $user
     *
     * @return bool
     */
    public function isDocumentEditAllowed(ShopDocument $document, User $user) {
        if ($user->isAllowed('documents-all-edit')) {
            return true;
        }

        if ($user->isAllowed('document-manager-'.$document->getUserid().'-edit')) {
            return true;
        }

        return false;
    }

    /**
     * Может ли пользователь заполнять поля в документе
     *
     * @param ShopDocument $document
     * @param User $user
     *
     * @return bool
     */
    public function isDocumentFieldsAllowed(ShopDocument $document, User $user) {
        if ($user->isAllowed('documents-all-edit')) {
            return true;
        }

        if ($user->isAllowed('document-manager-'.$document->getUserid().'-editfields')) {
            return true;
        }

        return false;
    }

    /**
     * Может ли пользователь удалить документ
     *
     * @param ShopDocument $document
     * @param User $user
     *
     * @return bool
     */
    public function isDocumentDeleteAllowed(ShopDocument $document, User $user) {
        if ($user->isAllowed('documents-all-delete')) {
            return true;
        }

        if ($user->isAllowed('document-manager-'.$document->getUserid().'-delete')) {
            return true;
        }

        return false;
    }

    /**
     * Сформировать документ
     *
     * @param User $user
     * @param string $name
     * @param int $templateID
     * @param string $linkKey
     * @param int $contractorID
     * @param string $sdate
     * @param string $bdate
     * @param string $adate
     * @param array $fileoriginal
     * @param array $assignArray
     * @param int $legalID
     *
     * @return ShopDocument
     *
     * @throws ServiceUtils_Exception
     */
    public function addDocument(User $user, $name, $templateID, $linkKey, $contractorID,
    $sdate, $bdate, $adate, $fileoriginal, $assignArray, $legalID = false) {
        try {
            SQLObject::TransactionStart();

            if ($templateID) {
                $template = $this->getDocumentTemplateByID($templateID);

                // проверка прав пользователя
                if (!$user->isAllowed('document-print-'.$template->getId())) {
                    throw new ServiceUtils_Exception('permission');
                }
            }

            if (!$name && !$templateID) {
                throw new ServiceUtils_Exception('document-name');
            }

            try {
                $contractor = Shop::Get()->getShopService()->getContractorByID($contractorID);
            } catch (ServiceUtils_Exception $ce) {
                $contractor = Shop::Get()->getShopService()->getContractorDefault();
            }

            if ($sdate) {
                $sdate = DateTime_Corrector::CorrectDateTime($sdate);
            }

            if ($bdate) {
                $bdate = DateTime_Corrector::CorrectDateTime($bdate);
            }

            if ($adate) {
                $adate = DateTime_Corrector::CorrectDateTime($adate);
            }

            $document = new ShopDocument();
            $document->setUserid($user->getId());
            $document->setCdate(date('Y-m-d H:i:s'));
            $document->setName($name);
            $document->setTemplateid($templateID);
            $document->setLinkkey($linkKey);
            $document->setContractorid($contractor->getId());
            $document->setSdate($sdate);
            $document->setBdate($bdate);
            $document->setAdate($adate);
            $document->insert();

            if (isset($template)) {
                // если у документа задан период (срок действия), то формируем дату edate
                if ($template->getPeriod()) {
                    $document->setEdate(DateTime_Object::Now()->addDay(+$template->getPeriod())->__toString());
                }

                if (!$name) {
                    $document->setName($template->getName());
                }
            }

            // генерация номера документа
            $number = $document->getId();
            if (isset($template)) {
                $numberProcessor = $template->getNumberprocessor();
                if (class_exists($numberProcessor)) {
                    $processor = new $numberProcessor();
                    $number = $processor->process($document);
                }
            }
            $document->setNumber($number);

            // формирование контента
            if (isset($template)) {
                $assignArray['date'] = DateTime_Formatter::DateISO8601($document->getCdate());
                $assignArray['documentid'] = $document->getId();
                $assignArray['documentNumber'] = $number;
                $assignArray['documentDate'] = DateTime_Formatter::DateISO8601($document->getCdate());
                $assignArray['documentDateTime'] = DateTime_Formatter::DateTimeISO9075($document->getCdate());
                $assignArray['documentBarcode'] = $document->makeBarcode();
                $assignArray['authorNameFull'] = $user->makeName();
                $assignArray['authorName'] = $user->makeName(true, 'lfm');

                if ($legalID) {
                    $legalData = new XShopUserLegalData();
                    $legalData->setLegalid($legalID);
                    $legalString = '';
                    while ($x = $legalData->getNext()) {
                        $legalString .= $x->getName().': '.$x->getValue()."\n";
                        $assignArray['client_legal_'.$x->getKey()] = $x->getValue();
                    }
                    $assignArray['client_legal'] = nl2br(trim($legalString));
                }

                $unlink = false;
                if (preg_match("/^file\:(.+?)$/ius", $template->getContent(), $r)) {
                    $contentFile = PackageLoader::Get()->getProjectPath().$r[1];
                } else {
                    $contentFile = MEDIA_PATH.'/tmp/'.rand().time();
                    file_put_contents($contentFile, $template->getContent());
                    $unlink = true;
                }

                $content = Engine::GetSmarty()->fetch($contentFile, $assignArray);
                if ($unlink) {
                    unlink($contentFile);
                }

                $document->setContent($content);

                if (preg_match_all("/\[(.+?)\]/ius", $content, $r)) {
                    $i = 0;
                    while ($i < count($r[1])) {
                        $fieldName = $r[1][$i];

                        $tmp = new XShopDocumentFieldValue();
                        $tmp->setDocumentid($document->getId());
                        $tmp->setName($fieldName);
                        if (!$tmp->select()) {
                            $tmp->insert();
                        }

                        $i++;
                    }
                }
            }

            // оригинальный файл
            if (!empty($fileoriginal['tmp_name'])) {
                $name = $fileoriginal['name'];
                $path = $fileoriginal['tmp_name'];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $md5 = md5(file_get_contents($path));

                $uploadName = $md5.'.'.$ext;

                copy($path, PackageLoader::Get()->getProjectPath().'media/document/'.$uploadName);
                $document->setFileoriginal($uploadName);
            }

            $document->update();

            if (preg_match("/^ShopOrder-(\d+)$/ius", $linkKey, $r)) {
                try {
                    $order = Shop::Get()->getShopService()->getOrderByID($r[1]);

                    // пишем комментарий в историю заказа

                    $orderComment = "Создан документ #".$document->getId();

                    if ($document->makeName()) {
                        $orderComment.= " - ".$document->makeName();
                    }

                    Shop::Get()->getShopService()->addOrderDocument(
                        $order,
                        $user,
                        $orderComment
                    );
                } catch (ServiceUtils_Exception $se) {

                }
            }

            SQLObject::TransactionCommit();

            return $document;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }
    
    /**
     * Редактировать документ
     *
     * @param ShopDocument $document
     * @param User $user
     * @param string $number
     * @param string $name
     * @param int $templateID
     * @param int $contractorID
     * @param string $cdate
     * @param string $sdate
     * @param string $bdate
     * @param string $adate
     * @param string $edate
     * @param array $file
     * @param array $fileoriginal
     * @param string $content
     *
     * @return ShopDocument
     *
     * @throws ServiceUtils_Exception
     */
    public function editDocument(ShopDocument $document, User $user, $number, $name, $templateID,
    $contractorID, $cdate, $sdate, $bdate, $adate, $edate, $file, $fileoriginal, $content) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            if (!$number) {
                $ex->addError('document-number');
            }

            if (!$name && !$templateID) {
                $ex->addError('document-name');
            }

            if (!$cdate) {
                $ex->addError('document-cdate');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $cdate = DateTime_Corrector::CorrectDateTime($cdate);

            if ($sdate) {
                $sdate = DateTime_Corrector::CorrectDateTime($sdate);
            }

            if ($bdate) {
                $bdate = DateTime_Corrector::CorrectDateTime($bdate);
            }

            if ($adate) {
                $adate = DateTime_Corrector::CorrectDateTime($adate);
            }

            if ($edate) {
                $edate = DateTime_Corrector::CorrectDateTime($edate);
            }

            try {
                $contractor = Shop::Get()->getShopService()->getContractorByID($contractorID);
            } catch (ServiceUtils_Exception $ce) {
                $contractor = Shop::Get()->getShopService()->getContractorDefault();
            }

            $document->setNumber($number);
            $document->setName($name);
            $document->setCdate($cdate);
            $document->setSdate($sdate);
            $document->setBdate($bdate);
            $document->setAdate($adate);
            $document->setEdate($edate);
            $document->setContractorid($contractor->getId());

            if ($templateID && $templateID != $document->getTemplateid()) {
                $template = $this->getDocumentTemplateByID($templateID);

                // проверка прав пользователя
                if (!$user->isAllowed('document-print-'.$template->getId())) {
                    throw new ServiceUtils_Exception('permission');
                }

                $document->setTemplateid($templateID);

                // если у документа задан период (срок действия)
                // то формируем дату edate
                if ($template->getPeriod() && !$edate) {
                    $document->setEdate(DateTime_Object::Now()->addDay(+$template->getPeriod())->__toString());
                }

                if (!$name) {
                    $document->setName($template->getName());
                }

                // формирование контента @todo
            }

            // файлы
            if (!empty($file['tmp_name'])) {
                $name = $file['name'];
                $path = $file['tmp_name'];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $md5 = md5(file_get_contents($path));

                $uploadName = $md5.'.'.$ext;

                copy($path, PackageLoader::Get()->getProjectPath().'media/document/'.$uploadName);
                $document->setFile($uploadName);
            }

            if (!empty($fileoriginal['tmp_name'])) {
                $name = $fileoriginal['name'];
                $path = $fileoriginal['tmp_name'];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $md5 = md5(file_get_contents($path));

                $uploadName = $md5.'.'.$ext;

                copy($path, PackageLoader::Get()->getProjectPath().'media/document/'.$uploadName);
                $document->setFileoriginal($uploadName);
            }

            if ($content) {
                $document->setContent($content);

                if (preg_match_all("/\[(.+?)\]/ius", $content, $r)) {
                    $i = 0;
                    while ($i < count($r[1])) {
                        $fieldName = $r[1][$i];

                        $tmp = new XShopDocumentFieldValue();
                        $tmp->setDocumentid($document->getId());
                        $tmp->setName($fieldName);
                        if (!$tmp->select()) {
                            $tmp->insert();
                        }

                        $i++;
                    }
                }
            }

            $document->update();

            $linkKey = $document->getLinkkey();
            if (preg_match("/^ShopOrder-(\d+)$/ius", $linkKey, $r)) {
                try {
                    $order = Shop::Get()->getShopService()->getOrderByID($r[1]);

                    // пишем комментарий в историю заказа

                    $orderComment = "Обновлен документ #".$document->getId();

                    if ($document->makeName()) {
                        $orderComment.= " - ".$document->makeName();
                    }

                    Shop::Get()->getShopService()->addOrderDocument(
                        $order,
                        $user,
                        $orderComment
                    );
                } catch (ServiceUtils_Exception $se) {

                }
            }

            SQLObject::TransactionCommit();

            return $document;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить документ
     *
     * @param ShopDocument $document
     * @param User $user
     *
     * @throws ServiceUtils_Exception
     */
    public function deleteDocument(ShopDocument $document, User $user) {
        try {
            SQLObject::TransactionStart();

            // проверка прав пользователя
            if (!$user->isAllowed('documents-all-delete')) {
                throw new ServiceUtils_Exception('permission');
            }

            // проверка удален документ или нет
            if (!$document->getDeleted()) {
                $document->setDeleted(1);
                $document->update();

                $linkKey = $document->getLinkkey();
                if (preg_match("/^ShopOrder-(\d+)$/ius", $linkKey, $r)) {
                    try {
                        $order = Shop::Get()->getShopService()->getOrderByID($r[1]);

                        // пишем комментарий в историю заказа

                        $orderComment = "Удален документ #".$document->getId();

                        if ($document->makeName()) {
                            $orderComment.= " - ".$document->makeName();
                        }

                        Shop::Get()->getShopService()->addOrderDocument(
                            $order,
                            $user,
                            $orderComment
                        );
                    } catch (ServiceUtils_Exception $se) {

                    }
                }
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить шаблон по id
     *
     * @param int $id
     *
     * @return ShopDocumentTemplate
     *
     * @throws ServiceUtils_Exception
     */
    public function getDocumentTemplateByID($id) {
        return $this->getObjectByID($id, 'ShopDocumentTemplate');
    }

    /**
     * Получить все шаблоны
     *
     * @return ShopDocumentTemplate
     */
    public function getDocumentTemplatesAll() {
        $x = new ShopDocumentTemplate();
        $x->setOrder(array('sort', 'name'), 'ASC');
        return $x;
    }

    /**
     * Получить все шаблоны (не скрытые)
     *
     * @return ShopDocumentTemplate
     */
    public function getDocumentTemplatesActive() {
        $x = $this->getDocumentTemplatesAll();
        $x->setHidden(0);
        return $x;
    }

    /**
     * Получить шаблоны для сущности
     *
     * @return ShopDocumentTemplate
     */
    public function getDocumentTemplatesByClassname($classname) {
        $x = $this->getDocumentTemplatesActive();
        $x->setType($classname);
        return $x;
    }

    /**
     * Получить сиписок id шаблонов, которые может печатать юзер
     *
     * @param User $cuser
     *
     * @return ShopDocumentTemplate
     */
    private function _getDocumentTemplateIDsArrayByUser(User $cuser) {
        $templates = $this->getDocumentTemplatesAll();
        $templateArray = array(-1);
        while ($template = $templates->getNext()) {
            if ($cuser->isAllowed('document-print-'.$template->getId())) {
                $templateArray[] = $template->getId();
            }
        }
        return $templateArray;
    }
    
    /**
     * Сформировать шаблон документа
     * 
     * @param string $name Название документа
     * @param string $content Шаблон документа
     * @param string $key ключ документа
     * @param string $type 'ShopOrder', 'User', 'ShopStorageTransaction'
     * @param boolean $hidden Скрытый документ 
     * @param boolean $required  Обязательный документ 
     * @param int $period Срок действия документа в днях 
     * @param int $sort Порядок сортировки
     * @param string $numberprocessor Программный обработчик нумерации
     * 
     * @return ShopDocumentTemplate
     */
    public function addDocumentTempalte($name, $content, $key, $type = 'ShopOrder',  $hidden = false, 
        $required = false, $period = false, $sort = false, $numberprocessor = false) {
        try{
            $ex = new ServiceUtils_Exception();

            if (!$name) {
                $ex->addError('name');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            $document = new XShopDocumentTemplate();
            $document->setKey($key);
            $document->setType($type);
            if ($document->select()) {
                return;
            }

            $content = trim($content);

            if (strpos($content, 'file:') === 0) {
                // пусть к файлу
                $document->setContent($content);
            } else {
                // контент
                if (strpos($document->getContent(), 'file:') === 0) {
                    // записываем в файл
                    $file = PackageLoader::Get()->getProjectPath();
                    $file.= str_replace('file:', '', $document->getContent());
                    file_put_contents($file, $content);

                } else {
                    // записываем в таблицу
                    $document->setContent($content);
                }

            }

            $document->setName($name);
            $document->setHidden($hidden);
            $document->setRequired($required);
            $document->setPeriod(trim($period));
            $document->setSort(trim($sort));
            $document->setNumberprocessor(trim($numberprocessor));

            $document->insert();

            return $document;

        } catch (ServiceUtils_Exception $oke) {
        }
    }
    
    /**
     * Get он и есть Get
     *
     * @return DocumentService
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __construct() {

    }

    private function __clone() {

    }

    private static $_Instance = null;

}