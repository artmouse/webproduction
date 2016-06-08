<?php
/**
 * Сервис, отвечающий за работу с уведомлениями (notify)
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 *
 * @copyright WebProduction
 *
 * @package OneBox
 */
class NotifyService {

    /**
     * Запустить notify processor
     */
    public function process() {
        ModeService::Get()->verbose('Process notifies...');

        try {
            $notifyArray = Engine::Get()->getConfigField('project-box-notify');

            // с каким workfkow
            $workflowID = Engine::Get()->getConfigField('project-box-notify-workflowid');

            $workflow = Shop::Get()->getShopService()->getOrderCategoryByID($workflowID);

            // статус для новых задач
            $statusStart = $workflow->getStatusDefault();

            // статус для завершенных задач
            $statusClosed = $workflow->getStatusClosed();

            // задачи, которые были обновлены или созданы
            $issueIDArray = array(-1);

            foreach ($notifyArray as $class) {
                if (!class_exists($class)) {
                    continue;
                }

                ModeService::Get()->verbose('Notify '.$class.'...');

                try {
                    $object = new $class();
                    $tmp = $object->process();

                    usleep(1000000 / rand(1, 1000)); // issue #63748 - smart timeout

                    // дописываем номера задач, которые были обновлены
                    if ($tmp) {
                        $issueIDArray = array_merge($issueIDArray, $tmp);
                    }
                } catch (Exception $e) {
                    ModeService::Get()->debug($e);
                }
            }

            // всем задачам задачам которые не были созданы/обновлены, ставим
            // статус closed в данном проекте с данным workflowID.
            $issues = IssueService::Get()->getIssuesAll();
            $issues->setCategoryid($workflowID);
            $issues->addWhereQuery("id NOT IN (".implode(',', $issueIDArray).")");
            $issues->setStatusid($statusStart->getId());
            while ($x = $issues->getNext()) {
                try {
                    // формально автор закрывает задачу
                    Shop::Get()->getShopService()->updateOrderStatus(
                        $x->getManagerOrAuthor(),
                        $x,
                        $statusClosed->getId()
                    );
                } catch (Exception $issueEx) {
                    ModeService::Get()->debug($issueEx);
                }
            }
        } catch (Exception $ge) {
            ModeService::Get()->verbose($ge);
        }
    }

    /**
     * Добавить нотификацию (проблему).
     *
     * Приоритеты:
     * -1 - не приоритетно (по умолчанию)
     * 0 - автоматически (больше 3х дней от cdate или edate просрочен)
     * 1 - всегда приоритетно
     *
     * @param User $user
     * @param string $linkkey
     * @param string $name
     * @param string $content
     * @param string $url
     * @param int $priority or string date
     * @param int $clientID
     * @param int $parentID
     * @param User $author
     */
    public function addNotify(User $user, $linkkey, $name, $content, $url, $priority = 0,
    $clientID = false, $parentID = false, $author = false) {
        if (!$user || !$linkkey || !$name) {
            throw new ServiceUtils_Exception();
        }

        try {
            SQLObject::TransactionStart();

            if (!$author) {
                // задачи будет создавать руководитель юзера
                try {
                    $author = $user->getManager();
                } catch (Exception $e) {
                    $author = $user;
                }
            }

            // с каким workfkow
            $workflowID = Engine::Get()->getConfigField('project-box-notify-workflowid');
            $workflow = Shop::Get()->getShopService()->getOrderCategoryByID($workflowID);

            // статус для новых задач
            $statusStart = $workflow->getStatusDefault();

            if (!$parentID) {
                $parentID = -1;
            }

            // если вызван текущий метод - то это означает, что проблема (уведомление)
            // уже есть. Пытаемся найти открытую задачу (без учета проекта) с таким linkkey.

            $issue = IssueService::Get()->getIssuesAll();
            $issue->setCategoryid($workflowID);
            $issue->setStatusid($statusStart->getId());
            $issue->setLinkkey($linkkey);
            if (!$issue->select()) {
                $dateto = false;

                if ($url) {
                    $url = Engine::Get()->getProjectURL().$url;
                    $content .= "\n\n".$url;
                }

                if ($priority == 1) {
                    //  для срочный задач приоритет на 1 день
                    $dateto = DateTime_Object::Now()->addDay(+1)->__toString();
                } elseif (Checker::CheckDate($priority)) {
                    $dateto = $priority;
                }

                $manager = $user->getId();

                if (Engine::Get()->getConfigFieldSecure('project-box-notify-manager-workflow')) {
                    try{
                        $manager = Shop::Get()->getUserService()->getUserByID($workflow->getManagerid())->getId();
                    } catch (Exception $emanager) {

                    }
                }

                // задача не найдена, будем создавать
                $issue = IssueService::Get()->addIssue(
                    $author, // кто создает
                    $name, // имя задачи
                    $content,
                    $manager, // на кого назначена
                    $workflowID,
                    $dateto,
                    $clientID,
                    $parentID
                );

                $issue->setLinkkey($linkkey);
                $issue->setPriority(99999);
                $issue->update();
            } else {
                // fix for old issues
                $issue->setParentid($parentID);

                // если дата больше - то переносим на сегодня
                if ($issue->getDateto() <= date('Y-m-d H:i:s')) {
                    $issue->setDateto(date('Y-m-d'));
                }
                if (!$issue->getPriority()) {
                    $issue->setPriority(99999);
                }
                $issue->update();
            }

            SQLObject::TransactionCommit();

            // возвращаем номер задачи
            return $issue->getId();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return NotifyService
     */
    public static function Get() {
        if (!self::$_Instance) {
            $classname = self::$_Classname;
            if ($classname) {
                self::$_Instance = new $classname();
            } else {
                self::$_Instance = new self();
            }
        }
        return self::$_Instance;
    }

    /**
     * Задать класс сервиса.
     * override-метод.
     *
     * @param string $classname
     */
    public static function Set($classname) {
        self::$_Classname = $classname;
        self::$_Instance = null;
    }

    /**
     * Подменяемый объект сервиса
     *
     * @var NotifyService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}