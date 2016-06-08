<?php
class action_block_term extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $status= $this->_getStatus();

        $this->setValue('term', $status->getTerm());
        $this->setValue('period', $status->getTermperiod());
    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'term' => $this->getArgumentSecure($index.'_term'),
            'period' => $this->getArgumentSecure($index.'_period')
        );

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($data)
        );

        $status = $this->_getStatus();
        $status->setTerm($this->getArgumentSecure($index.'_term'));
        $status->setTermperiod($this->getArgumentSecure($index.'_period'));
        $status->update();
    }

    public function processDataDelete() {
        $status = $this->_getStatus();
        $status->setTerm(0);
        $status->setTermperiod('');
        $status->update();
    }

    public function processCronHour(Events_Event $event) {
        $event;
        $status = $this->_getStatus();

        // получаем все задачи с нашим статусом
        $issue = Shop::Get()->getShopService()->getOrdersAll(false, false, 'issue');
        $issue->unsetField('issue'); // @todo
        $issue->setOrder('id', 'DESC');
        $issue->setType('issue');
        $issue->setDateclosed('0000-00-00 00:00:00');
        $issue->setStatusid($status->getId());
        while ($x = $issue->getNext()) {
            // для каждой задачи делаем проверку срока
            $tmp = new XShopOrderChange();
            $tmp->setOrderid($x->getId());
            $tmp->setOrder('id', 'DESC');
            $tmp->setLimitCount(1);
            $tmp->setKey('statusid');
            $tmp->setValue($status->getId());
            if ($xtmp = $tmp->getNext()) {
                try {
                    $employer = new XShopOrderEmployer();
                    $employer->setOrderid($x->getId());
                    $employer->setStatusid($status->getId());
                    $employer = $employer->getNext();

                    $statusDate = false;
                    if ($employer && $employer->getTerm() != '0000-00-00 00:00:00') {
                        $statusDate = $employer->getTerm();
                    } elseif ($status->getTerm()) {
                        $statusDate = DateTime_Object::FromString($xtmp->getCdate());

                        $term = $status->getTerm();
                        $period = $status->getTermperiod();

                        if ($period == 'hour') {
                            $statusDate->addHour($term);
                        } elseif ($period == 'day') {
                            $statusDate->addDay($term);
                        } elseif ($period == 'week') {
                            $statusDate->addDay($term * 7);
                        } elseif ($period == 'month') {
                            $statusDate->addMonth($term);
                        } elseif ($period == 'year') {
                            $statusDate->addYear($term);
                        } else {
                            // иначе дни
                            $statusDate->addDay($term);
                        }

                        $statusDate = $statusDate->__toString();
                    }

                    if ($statusDate && ($statusDate <= date('Y-m-d H:i:s'))) {
                        $comment =
                            Shop::Get()->getTranslateService()->getTranslateSecure(
                                'translate_zadacha_slishkom_dolgo_nahoditsya_v_sostoyanii_'
                            ).$x->getStatus()->getName().'. ';
                        if ($employer && $employer->getTerm() != '0000-00-00 00:00:00') {
                            $comment .=
                                Shop::Get()->getTranslateService()->getTranslateSecure(
                                    'translate_krayniy_srok_etogo_etapa_bil_opredelen_na_'
                                ).$employer->getTerm().'.';
                        } else {
                            $comment .=
                                Shop::Get()->getTranslateService()->getTranslateSecure('translate_dopustimoe_vremya_').
                                $term.' '.$period.'. ';
                            $comment .=
                                Shop::Get()->getTranslateService()->getTranslateSecure(
                                    'translate_krayniy_srok_etogo_etapa_bil_opredelen_na_'
                                ).$xtmp->getCdate().'.';
                        }

                        $term = DateTime_Object::Now()->addDay(-1)->__toString();

                            Shop::Get()->getShopService()->addOrderNotify($x, false, $comment, $term);
                    }
                } catch (Exception $statusEx) {

                }
            }
        }
    }

    /**
     * Обертка
     *
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
    }
}