<?php
class gantt_index extends Engine_Class {

    /**
     * Получить задачи
     * 
     * @return ShopOrder
     */
    private function _getIssues() {
        return $this->getValue('issue');
    }

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/categorySortable.js');

        $issues = $this->_getIssues();
        $issues->setOrder('id', 'ASC');
        $issues->setLimit(0, 0);

        // даты построения ганта
        $dateFrom = $this->getArgumentSecure('filtercdatefrom', 'date');
        $dateTo = $this->getArgumentSecure('filtercdateto', 'date');

        if (!$dateFrom) {
            $dateFrom = date('Y-m-01');
        }

        if (!$dateTo) {
            $dateTo = DateTime_Object::Now()->addMonth(+3)->setFormat('Y-m-t')->__toString();
        }

        $this->setValue('dateFrom', $dateFrom);
        $this->setValue('dateTo', $dateTo);

        // интервал дат
        $a = array();
        $b = array();
        $d = DateTime_Object::FromString($dateFrom)->setFormat('Y-m-d');
        while ($d->__toString() <= $dateTo) {
            $month = clone $d;
            $month->setFormat('Y-m');
            $month = $month->__toString();

            $tmp = clone $d;
            $tmp->setFormat('d');
            $a[] = $tmp->__toString();

            if (!isset($b[$month])) {
                $tmp = clone $d;
                $tmp->setFormat('t');
                $monthDayCount = $tmp->__toString();

                $b[$month] = $monthDayCount;
            }


            $d->addDay(+1);
        }
        $this->setValue('dayArray', $a);
        $this->setValue('monthArray', $b);

        $lineWidth = count($a) * 20;
        $this->setValue('lineWidth', $lineWidth);

        $block = Engine::GetContentDriver()->getContent('gantt-row-block');
        $block->setValue('parentid', 0);
        $block->setValue('issue', $issues);
        $block->setValue('lineWidth', $lineWidth);
        $block->setValue('dateFrom', $dateFrom);
        $this->setValue('block_row', $block->render());

        $a = array();
        $managers = Shop::Get()->getUserService()->getUsersManagers($this->getUser());
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(true, 'lfm'),
            );
        }
        $this->setValue('managerArray', $a);

        $a = array();
        $workflows = Shop::Get()->getShopService()->getWorkflowsActive($this->getUser());
        while ($x = $workflows->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            );
        }
        $this->setValue('workflowArray', $a);
    }

}