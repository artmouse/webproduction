<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class ShopOrder extends XShopOrder {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * Next
     *
     * @return ShopOrder
     */
    public function getNext($exception = false) {
        1;
        return parent::getNext($exception);
    }

    /**
     * Get
     *
     * @return ShopOrder
     */
    public static function Get($key) {
        return self::GetObject('ShopOrder', $key);
    }

    /**
     *  Получить товары
     *
     * @return ShopOrderProduct
     */
    public function getOrderProducts() {
        $products = Shop::Get()->getShopService()->getOrderProducts($this);
        $products->setOrder('sortable');

        return $products;
    }

    /**
     * URL для клиента
     *
     * @return string
     */
    public function makeURL() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-client-orders-view',
            $this->getId()
        );
    }

    /**
     * URL для админки
     *
     * @return string
     */
    public function makeURLEdit() {
        if (!Shop_ModuleLoader::Get()->isModuleInModulesArray('box')
            || Engine::Get()->getConfigFieldSecure('static-shop-menu')
        ) {
            if ($this->isProject()) {
                return Engine::GetLinkMaker()->makeURLByContentIDParam(
                    'admin-project-control',
                    $this->getId()
                );

            } elseif ($this->getIssue()) {
                return Engine::GetLinkMaker()->makeURLByContentIDParam(
                    'admin-issue-control',
                    $this->getId()
                );

            } else {
                return Engine::GetLinkMaker()->makeURLByContentIDParam(
                    'shop-admin-orders-control',
                    $this->getId()
                );

            }
        } else {
            $type = $this->getType();
            if (!$type) {
                try{
                    $type = $this->getWorkflow()->getType();
                } catch (Exception $eworkflow) {

                }
            }

            if (!$type) {
                $type = 'order';
            }
            return Engine::GetLinkMaker()->makeURLByContentIDParams(
                'custom-issue-shop-control',
                array(
                    'id' => $this->getId(),
                    'type' => $type
                )
            );
        }
    }

    public function getTypeName () {
        $type = new XShopWorkflowType();
        $type->setType($this->getType());
        if ($type->select()) {
            return $type->getName();
        } else {
            return $this->getType();
        }
    }

    public function makeDate() {
        return DateTime_Formatter::DateTimePhonetic($this->getCdate());
    }

    /**
     * Валюта заказа
     *
     * @return ShopCurrency
     */
    public function getCurrency() {
        // если по какой-то причине нет валюты - то возвращаем системную
        if (!$this->getCurrencyid()) {
            return Shop::Get()->getCurrencyService()->getCurrencySystem();
        }

        // иначе как обычно
        return Shop::Get()->getCurrencyService()->getCurrencyByID(
            $this->getCurrencyid()
        );
    }

    /**
     * Получить клиента
     *
     * @deprecated
     *
     * @see getClient()
     *
     * @return User
     */
    public function getUser() {
        return $this->getClient();
    }

    /**
     * Получить клиента
     *
     * @return User
     */
    public function getClient() {
        return Shop::Get()->getUserService()->getUserByID(
            $this->getUserid()
        );
    }

    /**
     * Получить менеджера
     *
     * @return User
     */
    public function getManager() {
        return Shop::Get()->getUserService()->getUserByID(
            $this->getManagerid()
        );
    }

    /**
     * Получить автора заказа
     *
     * @return User
     */
    public function getAuthor() {
        return Shop::Get()->getUserService()->getUserByID(
            $this->getAuthorid()
        );
    }

    /**
     * Получить менеджера или автора
     *
     * @return User
     */
    public function getManagerOrAuthor() {
        try {
            return $this->getManager();
        } catch (Exception $e) {

        }

        try {
            return $this->getAuthor();
        } catch (Exception $e) {

        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Получить способ оплаты заказа
     *
     * @return ShopPayment
     */
    public function getPayment() {
        return Shop::Get()->getShopService()->getPaymentByID(
            $this->getPaymentid()
        );
    }

    /**
     * Получить статус заказа
     *
     * @return ShopOrderStatus
     */
    public function getStatus() {
        return WorkflowService::Get()->getStatusByID(
            $this->getStatusid()
        );
    }

    /**
     * Получить вариант доставки заказа
     *
     * @return ShopDelivery
     */
    public function getDelivery() {
        return Shop::Get()->getDeliveryService()->getDeliveryByID(
            $this->getDeliveryid()
        );
    }

    /**
     * Получить процент скидки
     *
     * @return float
     */
    public function getDiscountPercent() {
        try {
            $discount = Shop::Get()->getShopService()->getDiscountByID(
                $this->getDiscountid()
            );

            if ($discount->getType() == 'percent') {
                $discountPercent = $discount->getValue();
            } else {
                $discountPercent = 0;
            }
        } catch (Exception $e) {
            $discountPercent = 0;
        }

        return $discountPercent;
    }

    /**
     * Получить сумму скидки
     *
     * @param ShopCurrency $currency
     *
     * @return float
     */
    public function getDiscountValue(ShopCurrency $currency) {
        try {
            $discount = Shop::Get()->getShopService()->getDiscountByID(
                $this->getDiscountid()
            );

            if ($discount->getType() == 'value') {
                $discountSum = Shop::Get()->getCurrencyService()->convertCurrency(
                    $discount->getValue(),
                    $discount->getCurrency(),
                    $currency
                );
            } else {
                $discountSum = 0;
            }
        } catch (Exception $e) {
            $discountSum = 0;
        }

        return $discountSum;
    }

    /**
     * Get dateto
     *
     * @return string
     */
    public function getDateto() {
        $dateto = parent::getDateto();
        if (!$dateto || $dateto == '0000-00-00 00:00:00') {
            return '';
        }

        return $dateto;
    }

    /**
     * Получить юрлицо данного заказа
     *
     * @return ShopContractor
     */
    public function getContractor() {
        return Shop::Get()->getShopService()->getContractorByID($this->getContractorid());
    }

    /**
     * Это проект?
     *
     * @return bool
     */
    public function isProject() {
        return ($this->getType() == 'project');
    }

    /**
     * Это задача?
     *
     * @return bool
     */
    public function isIssue() {
        return ($this->getType() == 'issue');
    }

    /**
     * Посчитать НДС заказа
     *
     * @return float
     */
    public function makeTaxSum() {
        try {
            $tax = $this->getContractor()->getTax();
        } catch (Exception $e) {
            // можем сразу выходить
            return 0;
        }

        return Shop::Get()->getShopService()->calculateSum(
            $this->getSum(),
            $tax,
            0,
            0,
            false, // no sum
            true, // tax
            false // no discount
        );
    }
    
    /**
     * Получить количество продуктов заказа
     *
     * @return int 
     */
    public function getOrderProductsCount($orderID) {
        $allOrderProduct = Shop::Get()->getShopService()->getOrderProductsAll();
        $allOrderProduct->setOrderid($orderID);
        $count = 0;
        while ($x = $allOrderProduct->getNext()) {
            $count += $x->getProductcount() + 0;
        }
        return $count;
    }

    /**
     * Получить массив данных для формирования документов
     *
     * @return array
     */
    public function makeAssignArrayForDocument() {
        return Shop::Get()->getShopService()->makeOrderAssignArrayForDocument($this);
    }

    /**
     * Получить цвет в зависимости от id
     * @return mixed
     */
    public function makeColor() {
        $colorArray = array();
        $colorArray[] = 'aqua';
        $colorArray[] = 'greenyellow';
        $colorArray[] = 'blue';
        $colorArray[] = 'brown';
        $colorArray[] = 'coral';
        $colorArray[] = 'green';
        $colorArray[] = 'gold';
        $colorArray[] = 'silver';
        $colorArray[] = 'crimson';
        $colorArray[] = 'violet';

        $s = $this->getId().'';
        $digit = substr($s, strlen($s) - 1, 1);

        return $colorArray[$digit];
    }

    /**
     * Получить штрих-код
     *
     * @return string
     */
    public function makeBarcode() {
        $file = MEDIA_PATH.'/document/order-barcode'.$this->getId().'.png';
        Shop::Get()->getShopService()->createBarcodeImage($file, $this->getId());
        return MEDIA_DIR.'/document/order-barcode'.$this->getId().'.png?'.time();
    }

    /**
     * Реквизиты
     *
     * @return XShopUserLegal
     */
    public function makeLegalForDocument() {
        $legal = new XShopUserLegal();
        $legal->setUserid($this->getUserid());
        $legal->setOrder('name', 'ASC');
        return $legal;
    }

    /**
     * Получить категорию (БП)
     *
     * @return ShopOrderCategory
     *
     * @deprecated
     *
     * @see getWorkflow()
     */
    public function getCategory() {
        return $this->getWorkflow();
    }

    /**
     * Получить категорию (БП)
     *
     * @return ShopOrderCategory
     */
    public function getWorkflow() {
        return Shop::Get()->getShopService()->getOrderCategoryByID(
            $this->getCategoryid()
        );
    }

    public function getWorkflowid() {
        return $this->getCategoryid();
    }

    /**
     * Получить источник
     *
     * @return ShopSource
     */
    public function getSource() {
        return Shop::Get()->getShopService()->getSourceByID(
            $this->getSourceid()
        );
    }

    /**
     * Посчитать сумму оплат по заказу.
     * Возвращает в валюте заказа.
     *
     * @return float
     */
    public function makeSumPaid($virtual = false) {
        if (!Shop_ModuleLoader::Get()->isImported('finance')) {
            return 0;
        }

        return PaymentService::Get()->calculatePaymentSumByOrder($this, $virtual);
    }

    /**
     * Посчитать сумму заказу и под задачах.
     * Возвращает в валюте заказа.
     *
     * @return float
     */
    public function makeSum() {
        return Shop::Get()->getShopService()->calculateOrderSum($this);
    }

    /**
     * Посчитать баланс заказа.
     * Возвращает в валюте заказа.
     *
     * @return float
     */
    public function makeSumBalance($virtual = false) {
        return round($this->makeSumPaid($virtual) - $this->makeSum(), 2);
    }

    public function insert() {
        $this->setUdate(date('Y-m-d H:i:s'));

        $a = $this->getValues();
        if (isset($a['dateto'])) {

            $dateto = trim($a['dateto']);

            if ($dateto == '0000-00-00 00:00:00' || !$dateto) {
                $this->setDatetoday(0);
                $this->setDatetomonth(0);
                $this->setDatetoyear(0);
            } else {
                $this->setDatetoday(DateTime_Object::FromString($dateto)->setFormat('d'));
                $this->setDatetomonth(DateTime_Object::FromString($dateto)->setFormat('m'));
                $this->setDatetoyear(DateTime_Object::FromString($dateto)->setFormat('Y'));
            }
        }

        /*try {
            $user = Shop::Get()->getUserService()->getUser();
            if ($user) {
                $this->setUuserid($user->getId());
            }
        } catch (Exception $e) {

        }*/

        $result = parent::insert();

        if (!$this->getNumber()) {
            $this->setNumber($this->getId());
            $this->update();
        }

        return $result;
    }

    public function update($massUpdate = false) {
        //$this->setUdate(date('Y-m-d H:i:s'));

        if (!$this->getNumber()) {
            $this->setNumber($this->getId());
            $this->update();
        }

        if (!$massUpdate) {
            $a = $this->getValueUpdateArray();
            if (isset($a['dateto'])) {

                $dateto = trim($a['dateto']);

                if ($dateto == '0000-00-00 00:00:00' || !$dateto) {
                    $this->setDatetoday(0);
                    $this->setDatetomonth(0);
                    $this->setDatetoyear(0);
                } else {
                    $this->setDatetoday(DateTime_Object::FromString($dateto)->setFormat('d'));
                    $this->setDatetomonth(DateTime_Object::FromString($dateto)->setFormat('m'));
                    $this->setDatetoyear(DateTime_Object::FromString($dateto)->setFormat('Y'));
                }
            }
        }

        /*try {
            $user = Shop::Get()->getUserService()->getUser();
            if ($user) {
                $this->setUuserid($user->getId());
            }
        } catch (Exception $e) {

        }*/

        return parent::update($massUpdate);
    }

    /**
     * Получить номер заказа
     *
     * @return string
     */
    public function getNumber($real = false) {
        if ($real) {
            $x = parent::getNumber();
            if ($x == $this->getId()) {
                return false;
            }
            return $x;
        }

        $x = parent::getNumber();
        if ($x) {
            return $x;
        }
        return $this->getId();
    }

    /**
     * Построить имя заказа
     *
     * @param bool $autoName
     *
     * @return string
     */
    public function makeName($escape = false) {
        $name = '';
        $number = $this->getNumber(true);
        if ($number) {
            $name .= $number;
        } else {
            $name .= '#'.$this->getId();
        }
        if ($this->getName()) {
            $name .= ' - '.$this->getName();
        }
        if ($escape) {
            $name = htmlspecialchars($name);
        }

        return $name;
    }

    /**
     * Посчитать сумму без НДС
     *
     * @return float
     */
    public function makeSumWithoutTax() {
        return round($this->getSum() - $this->makeTaxSum(), 2);
    }

    /**
     * Получить первый комментарий к заказу
     *
     * @return string
     */
    public function makeComment() {
        PackageLoader::Get()->import('CommentsAPI');

        $commentKey = 'shop-order-'.$this->getId();


        $comments = CommentsAPI::Get()->getComments($commentKey);
        $comments->setOrder('cdate', 'DESC');
        $comments->addWhereArray(array ('comment', 'commentresult'), 'type');
        $comments->setLimitCount(1);
        if ($x = $comments->getNext()) {
            return $x->getContent();
        }

        return false;
    }

    /**
     * Получить время на выполнение задачи
     *
     * @return float
     */
    public function makeEstimateTime() {
        $x = $this->getEstimate();

        $subIssues = IssueService::Get()->getIssuesAll();
        $subIssues->setParentid($this->getId());
        while ($issue = $subIssues->getNext()) {
            if ($issue->getId() != $this->getId()) {
                $x += $issue->makeEstimateTime();
            }
        }

        $x = round($x, 2);
        return $x;
    }

    /**
     * Получить деньги на выполнение задачи
     *
     * @return float
     */
    public function makeEstimateMoney() {
        $x = $this->getMoney();

        $subIssues = IssueService::Get()->getIssuesAll();
        $subIssues->setParentid($this->getId());
        while ($issue = $subIssues->getNext()) {
            if ($issue->getId() != $this->getId()) {
                $x += $issue->makeEstimateMoney();
            }
        }

        $x = round($x, 2);
        return $x;
    }

    /**
     * Считается ли задача закрытой?
     *
     * @return bool
     */
    public function isClosed() {
        if (!$this->getDateclosed()) {
            return false;
        }
        return $this->getDateclosed() != '0000-00-00 00:00:00';
    }

    /**
     * Получить родительскую задачу или проект
     *
     * @return ShopOrder
     */
    public function getParent() {
        return Shop::Get()->getShopService()->getOrderByID(
            $this->getParentid()
        );
    }

    /**
     * Посчитать Маржу в системной валюте
     *
     * @return float|int
     */
    public function makeMargin() {
        $orderProduct = $this->getOrderProducts();
        $marginReturn = 0;
        while ($x = $orderProduct->getNext()) {
            $price = Shop::Get()->getCurrencyService()->convertCurrency(
                $x->getProductprice(),
                $x->getCurrency(),
                Shop::Get()->getCurrencyService()->getCurrencySystem()
            );

            $margin = Shop::Get()->getCurrencyService()->convertCurrency(
                $x->getProduct()->getPricebase(),
                $x->getCurrency(),
                Shop::Get()->getCurrencyService()->getCurrencySystem()
            );

            $marginReturn += ($price - $margin) * $x->getProductcount();
        }

        return $marginReturn;
    }

}