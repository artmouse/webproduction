<?php
/**
 * Сервис по работе с KPI
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   OneBox
 */
class KPIService {

    /**
     * Добавить (зарегистрировать) новый KPI или поправить KPI, если есть с таким-же logicclass+param.
     *
     * Важно: делается проверка logicclass + param.
     *
     * @param string $name
     * @param string $logicclass
     * @param string $param
     *
     * @return XShopKPI
     */
    public function addKPI($logicclass, $name, $param = '') {
        $name = trim($name);
        $logicclass = trim($logicclass);
        $param = trim($param);

        if (!$name) {
            throw new ServiceUtils_Exception('kpi.name');
        }

        if (!$logicclass) {
            throw new ServiceUtils_Exception('kpi.logicclass');
        }

        try {
            SQLObject::TransactionStart();

            $kpi = new XShopKPI();
            $kpi->setLogicclass($logicclass);
            $kpi->setLogicclassparam($param);
            if ($kpi->select()) {
                if ($kpi->getName() != $name) {
                    $kpi->setName($name);
                    $kpi->update();
                }
            } else {
                $kpi = new XShopKPI();
                $kpi->setName($name);
                $kpi->setLogicclass($logicclass);
                $kpi->setLogicclassparam($param);
                $kpi->insert();
            }

            SQLObject::TransactionCommit();

            return $kpi;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Запустить просчет всех KPI.
     * Метод вызывается в cron hour
     */
    public function processKPI() {
        ModeService::Get()->verbose("Process KPI...");

        $cdate = date('Y-m-d H').':00:00';

        $roles = RoleService::Get()->getRoleAll();
        while ($role = $roles->getNext()) {
            $kpis = $this->getKPIByRole($role);
            while ($kpi = $kpis->getNext()) {
                $classname = $kpi->getLogicclass();
                if (!$classname) {
                    continue;
                }
                if (!class_exists($classname)) {
                    continue;
                }

                // параметр
                $param = $this->getKPIParamByRole($role, $kpi);

                $processor = new $classname();

                // получаем всех сотрудников
                $users = RoleService::Get()->getUsersByRole($role->getName());
                $users->setEmployer(1);
                while ($user = $users->getNext()) {
                    // обрабатываем KPI
                    try {
                        $value = $processor->process($user, $param);
                    } catch (Exception $e) {
                        // если будет exception - то просто пропускаем
                        continue;
                    }

                    // какое плановое значение KPI на текущий момент?
                    $valuePlan = $this->getKPIFactByRole($role, $kpi);

                    // сохраняем KPI
                    $tmp = new XShopKPIUser();
                    $tmp->setKpiid($kpi->getId());
                    $tmp->setCdate($cdate);
                    $tmp->setUserid($user->getId());
                    if ($tmp->select()) {
                        $tmp->setValue($value);
                        $tmp->setValueplan($valuePlan);
                        $tmp->update();
                    } else {
                        $tmp->setValue($value);
                        $tmp->setValueplan($valuePlan);
                        $tmp->insert();
                    }

                    // является ли этот KPI условием начисления ЗП?
                    try {
                        $workflow = $this->getKPISalaryWorkflowByRole($role, $kpi);
                        $koef = $this->getKPISalaryKoefByRole($role, $kpi);

                        // множим на -1 если заказ исходящий
                        if ($workflow->getOutcoming()) {
                            $koef *= -1;
                        }

                        // ищем заказ по linkkey
                        $linkkey = 'salary-'.$user->getId().'-'.date('Ym');

                        $order = new ShopOrder();
                        $order->setDeleted(0);
                        $order->setLinkkey($linkkey);
                        $order->setUserid($user->getId());
                        $order->setCategoryid($workflow->getId());
                        if (!$order->select()) {
                            $order = Shop::Get()->getShopService()->addOrder(
                                $user, // author of salary order
                                'Заработная плата '.$user->makeName(false, 'lfm').' за '.date('Y-m'),
                                '', // content
                                $user->getId(), // managerid
                                $workflow->getId(),
                                false, // dateto
                                $user->getId() // clientID
                            );

                            $order->setLinkkey($linkkey);
                            $order->update();
                        }

                        // в этом заказе ищем нужный orderproduct
                        $op = new ShopOrderProduct();
                        $op->setOrderid($order->getId());
                        $op->setLinkkey('kpi-'.$kpi->getId());
                        if (!$op->select()) {
                            $op->setCurrencyid($order->getCurrencyid()); // копируем валюту заказа, обязательно.
                            $op->insert();
                        }
                        // и записываем туда данные о ЗП
                        $op->setProductname($kpi->getName());
                        $op->setProductcount($value);
                        $op->setProductprice($koef);
                        $op->update();

                        Shop::Get()->getShopService()->recalculateOrderSums($order);
                    } catch (Exception $salaryEx) {
                        print $salaryEx;
                    }
                }
            }
        }
    }

    /**
     * Получить все KPI по роли
     *
     * @param XShopRole $role
     *
     * @return XShopKPI
     */
    public function getKPIByRole(XShopRole $role) {
        $a = array(-1);
        for ($j = 1; $j <= 10; $j++) {
            $kpiID = $role->getField('kpi'.$j.'id');
            if ($kpiID) {
                $a[] = $kpiID;
            }
        }
        $x = $this->getKPIAll();
        $x->filterID($a);
        return $x;
    }

    /**
     * Получить рекомендумое фактическое значение KPI по заданной роли
     *
     * @param XShopRole $role
     * @param XShopKPI $kpi
     *
     * @return float
     */
    public function getKPIFactByRole(XShopRole $role, XShopKPI $kpi) {
        for ($j = 1; $j <= 10; $j++) {
            $kpiID = $role->getField('kpi'.$j.'id');
            if ($kpiID == $kpi->getId()) {
                return (float) $role->getField('kpi'.$j.'value');
            }
        }

        return false;
    }

    /**
     * Получить БП, который отвечает за начисление ЗП по этому KPI
     *
     * @param XShopRole $role
     * @param XShopKPI $kpi
     *
     * @return ShopOrderCategory
     */
    public function getKPISalaryWorkflowByRole(XShopRole $role, XShopKPI $kpi) {
        $workflowID = 0;

        for ($j = 1; $j <= 10; $j++) {
            $kpiID = $role->getField('kpi'.$j.'id');
            if ($kpiID == $kpi->getId()) {
                $workflowID = $role->getField('salary'.$j.'workflowid');
            }
        }

        return Shop::Get()->getShopService()->getWorkflowByID($workflowID);
    }

    /**
     * Получить коефициент, который отвечает за начисление ЗП по этому KPI.
     * KPI просто берется и множится на этот коеффициент - и это становится частью ЗП.
     *
     * @param XShopRole $role
     * @param XShopKPI $kpi
     *
     * @return float
     */
    public function getKPISalaryKoefByRole(XShopRole $role, XShopKPI $kpi) {
        for ($j = 1; $j <= 10; $j++) {
            $kpiID = $role->getField('kpi'.$j.'id');
            if ($kpiID == $kpi->getId()) {
                return (float) $role->getField('salary'.$j.'koef');
            }
        }
    }

    /**
     * Получить параметр KPI по заданной роли
     *
     * @param XShopRole $role
     * @param XShopKPI $kpi
     *
     * @return string
     */
    public function getKPIParamByRole(XShopRole $role, XShopKPI $kpi) {
        $a = array(-1);
        for ($j = 1; $j <= 10; $j++) {
            $kpiID = $role->getField('kpi'.$j.'id');
            if ($kpiID == $kpi->getId()) {
                $param = $role->getField('kpi'.$j.'param');
                break;
            }
        }

        if (!$param) {
            $param = $kpi->getLogicclassparam();
        }

        return $param;
    }

    /**
     * Получить KPI по ID
     *
     * @param int $kpiID
     *
     * @return XShopKPI
     */
    public function getKPIByID($kpiID) {
        $x = new XShopKPI($kpiID);
        if ($x->getId()) {
            return $x;
        }
        throw new ServiceUtils_Exception();
    }

    /**
     * Получить все KPI
     *
     * @return XShopKPI
     */
    public function getKPIAll() {
        $x = new XShopKPI();
        $x->setOrder('name', 'ASC');
        return $x;
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return KPIService
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

    private static $_Instance = null;

    private static $_Classname = false;

}