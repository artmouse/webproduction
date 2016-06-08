<?php
/**
 * WorkflowService отвечает за работу с бизнес-процессами их статусами (этапами) бизнес-процессов
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   OneBox
 */
class WorkflowService extends ServiceUtils_AbstractService {

    /**
     * Получить все статусы заказов
     *
     * @return ShopOrderStatus
     */
    public function getStatusAll() {
        $x = $this->getObjectsAll('ShopOrderStatus');
        $x->setOrder(array('sort', 'name'), 'ASC');
        return $x;
    }

    /**
     * Получить статус заказа по ID
     *
     * @param int $id
     *
     * @return ShopOrderStatus
     */
    public function getStatusByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopOrderStatus');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Получить все статусы с заданным именем.
     *
     * @param string $name
     *
     * @return ShopOrderStatus
     */
    public function getStatusesByName($name) {
        $status = Shop::Get()->getShopService()->getStatusAll();
        $status->filterName($name);
        return $status;
    }

    /**
     * Получить массив ID статусов по имени статуса.
     * Метод бывает очень полезный, если нужно выбрать все статусы с заданными именем.
     *
     * @param string $name
     *
     * @return array
     */
    public function getStatusIDArrayByName($name) {
        $status = $this->getStatusesByName($name);
        $a = array(-1);
        while ($x = $status->getNext()) {
            $a[] = $x->getId();
        }
        return $a;
    }

    /**
     * Получить все типы бизнес-процессов
     *
     * @return XShopWorkflowType
     */
    public function getWorkflowTypesAll() {
        $x = new XShopWorkflowType();
        $x->setOrder('name', 'ASC');
        return $x;
    }

    /**
     * Получить имя типа задач.
     * Если такого имени нет - то вернет название типа $type
     *
     * @param string $type
     *
     * @return string
     */
    public function getWorkflowTypeName($type) {
        if (!$type) {
            return false;
        }

        $typeName = new XShopWorkflowType();
        $typeName->setType($type);
        if ($typeName->select()) {
            return $typeName->getName();
        } else {
            return $type;
        }
    }

    /**
     * Получить категорию (бизнес-процесс)
     *
     * @param int $id
     *
     * @return ShopOrderCategory
     */
    public function getWorkflowByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopOrderCategory');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('Workflow by id not found');
    }

    /**
     * Получить все бизнес-процессы (workflow)
     *
     * @return ShopOrderCategory
     */
    public function getWorkflowsAll($user = false, $currentWorkflowID = false) {
        $x = $this->getObjectsAll('ShopOrderCategory');
        $x->setOrder('name', 'ASC');

        if ($user) {
            // массив с разрешенными workflow
            $a = array(-1);

            // идем по всем workflow,
            // получаем их тип,
            // проверяем "можно или нельзя"
            $workflows = $this->getWorkflowsAll();
            while ($w = $workflows->getNext()) {
                $type = $w->getType();

                if ($user->isAllowed($type.'-category-all-view')) {
                    $a[] = $w->getId();
                } elseif ($user->isAllowed($type.'-category-'.$w->getId().'-view')) {
                    $a[] = $w->getId();
                }
            }

            // дописываем текущий WF
            if ($currentWorkflowID) {
                $a[] = $currentWorkflowID;
            }

            $x->addWhereArray($a);
        }

        return $x;
    }

    /**
     * Получить все активные workflow
     *
     * @return ShopOrderCategory
     */
    public function getWorkflowsActive($user = false) {
        $x = $this->getWorkflowsAll($user);
        $x->setHidden(0);
        return $x;
    }

    /**
     * Получить бизнес-процесс по умолчанию для заданого типа БП
     *
     * @param string $type
     *
     * @return ShopOrderCategory
     */
    public function getWorkflowDefault($type = 'order') {
        $x = new ShopOrderCategory();
        $x->setType($type);
        $x->setDefault(1);
        if ($x->select()) {
            return $x;
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Получить стартовый статус
     *
     * @return ShopOrderStatus
     */
    public function getStatusDefault(ShopOrderCategory $workflow) {
        $status = $this->getStatusesByWorkflow($workflow);
        $status->setDefault(1);
        if ($x = $status->getNext()) {
            return $x;
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Получить завершенный статус
     *
     * @return ShopOrderStatus
     */
    public function getStatusClosed(ShopOrderCategory $workflow) {
        $status = $this->getStatusesByWorkflow($workflow);
        $status->setClosed(1);
        if ($x = $status->getNext()) {
            return $x;
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Получить следующие статусы по Бизнес-процессу
     *
     * @param ShopOrderCategory $workflow
     * @param ShopOrderStatus $status
     *
     * @return ShopOrderStatus
     */
    public function getStatusNextByWorkflow(ShopOrderCategory $workflow, ShopOrderStatus $status) {
        $statuses = new XShopOrderStatusChange();
        $statuses->filterCategoryid($workflow->getId());
        $statuses->filterElementfromid($status->getId());
        $statusesArray = array();
        while ($x = $statuses->getNext()) {
            $statusesArray[] = $x->getElementtoid();
        }

        $nextStatus = $this->getStatusAll();
        $nextStatus->setCategoryid($workflow->getId());
        $nextStatus->addWhereArray($statusesArray);
        return $nextStatus;
    }

    /**
     * Узнать, можно ли со статуса $from переходить в статус $to
     *
     * @param ShopOrderStatus $from
     * @param ShopOrderStatus $to
     *
     * @return bool
     */
    public function isStatusCanChangeToStatus(ShopOrderStatus $from, ShopOrderStatus $to) {
        $tmp = new XShopOrderStatusChange();
        $tmp->setCategoryid($from->getCategoryid());
        $tmp->setElementfromid($from->getId());
        $tmp->setElementtoid($to->getId());
        if ($tmp->select()) {
            return true;
        }
        return false;
    }

    /**
     * Получить статусы бизнес-процесса
     *
     * @param ShopOrderCategory $workflow
     *
     * @return ShopOrderStatus
     */
    public function getStatusesByWorkflow(ShopOrderCategory $workflow) {
        $statuses = $this->getStatusAll();
        $statuses->setCategoryid($workflow->getId());
        return $statuses;
    }

    /**
     * Найти все статусы, в которых задача считается закрытой.
     * Проверить все задачи в этих статусах и закрыть их, если
     * они еще не закрыты.
     */
    public function processStatusClosed() {
        ModeService::Get()->verbose('Process status closed...');

        $statuses = $this->getStatusAll();
        $statuses->setClosed(1);
        $a = array(-1);
        while ($x = $statuses->getNext()) {
            $a[] = $x->getId();
        }

        $orders = new ShopOrder();
        $orders->addWhereArray($a, 'statusid');
        $orders->setDateclosed('0000-00-00 00:00:00');
        $orders->setOrder('id', 'DESC');
        while ($x = $orders->getNext()) {
            print "Close order#".$x->getId()."\n";
            if (Checker::CheckDate($x->getUdate())) {
                $x->setDateclosed($x->getUdate());
                $x->update();
            } else {
                $x->setDateclosed(date('Y-m-d H:i:s'));
                $x->update();
            }
        }
    }

    /**
     * Найти все статусы, в которых задача считается открытой.
     * Проверить все задачи в этих статусах и открыть их, если
     * они еще не открыты.
     */
    public function processStatusOpened() {
        ModeService::Get()->verbose('Process status opened...');

        $statuses = $this->getStatusAll();
        $statuses->setClosed(0);
        $a = array(-1);
        while ($x = $statuses->getNext()) {
            $a[] = $x->getId();
        }

        $orders = new ShopOrder();
        $orders->addWhereArray($a, 'statusid');
        $orders->addWhere('dateclosed', '0000-00-00 00:00:00', '!=');
        $orders->setOrder('id', 'DESC');
        while ($x = $orders->getNext()) {
            print "Open order#".$x->getId()."\n";

            $x->setDateclosed('0000-00-00 00:00:00');
            $x->update();
        }
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return WorkflowService
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
     * @var WorkflowService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}