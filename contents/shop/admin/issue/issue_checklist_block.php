<?php
class issue_checklist_block extends Engine_Class {

    /**
     * @return ShopOrder
     */
    private function _getIssue() {
        return $this->getValue('issue');
    }

    public function process() {
        $issue = $this->_getIssue();

        // обновляем чек-листы
        $checklist = new XShopOrderChecklist();
        $checklist->setOrderid($issue->getId());
        while ($x = $checklist->getNext()) {
        	try {
        	    $checked = $this->getArgument('checklist'.$x->getId());

        	    if ($checked) {
        	        if (!Checker::CheckDate($x->getDateclosed())) {
                        $x->setDateclosed(date('Y-m-d H:i:s'));
                        $x->setCloseuserid($this->getUser()->getId());
                        $x->update();
        	        }
        	    } else {
        	        $x->setDateclosed('0000-00-00 00:00:00');
        	        $x->update();
        	    }
        	} catch (Exception $e) {

        	}
        }

        try {
            $checklistAdd = $this->getArgument('checklistadd');
            $checklistAdd = explode("\n", $checklistAdd);
            foreach ($checklistAdd as $x) {
            	$x = trim($x);
            	if (!$x) {
            		continue;
            	}
            	$cl = new XShopOrderChecklist();
            	$cl->setOrderid($issue->getId());
            	$cl->setStatusid($issue->getStatusid());
            	$cl->setName($x);
            	if (!$cl->select()) {
            		$cl->setCdate(date('Y-m-d H:i:s'));
            		$cl->insert();
            	}
            }
        } catch (Exception $e) {

        }

        // чек-лист
        $checklistSize = 0;
        $checklistDone = 0;
        $checklist = new XShopOrderChecklist();
        $checklist->setOrderid($issue->getId());
        $a = array();
        while ($x = $checklist->getNext()) {
            $closed = Checker::CheckDate($x->getDateclosed());

            $a[] = array(
            'id' => $x->getId(),
            'closed' => $closed,
            'name' => htmlspecialchars($x->getName()),
            );

            $checklistSize ++;
            $checklistDone += $closed;
        }
        $this->setValue('checklistArray', $a);
        $checklistProgress = 0;
        if ($checklistSize) {
            $checklistProgress = round($checklistDone / $checklistSize * 100);
        }
        $this->setValue('checklistProgress', $checklistProgress);
    }

}