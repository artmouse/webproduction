<?php
class structure_block extends Engine_Class {

    public function process() {
        $parentID = (int) $this->getValue('parentid');

        $this->setValue('roleArray', $this->_makeRoleArray($parentID));
    }

    private function _makeRoleArray($parentID = 0) {
        $role = RoleService::Get()->getRoleAll();
        $role->setParentid($parentID);

        $a = array();
        while ($x = $role->getNext()) {
            // сотрудники
            $employerArray = array();
            $employer = Shop::Get()->getUserService()->getUsersByRole($x->getName());
            $employer->setEmployer(1);
            while ($e = $employer->getNext()) {
                $employerArray[] = array(
                'id' => $e->getId(),
                'url' => $e->makeURLEdit(),
                'name' => $e->makeName(true, 'lfm'),
                );
            }

            // бизнес-процессы
            $workflowArray = array();
            $status = Shop::Get()->getShopService()->getStatusAll();
            $status->setRoleid($x->getId());
            $statusCount = 0;
            while ($s = $status->getNext()) {
                try {
                    // статистика задач
                    $issues = IssueService::Get()->getIssuesAll();
                    $issues->setStatusid($s->getId());
                    $count = $issues->getCount();

                    $statusCount += $count;

                    $workflowArray[] = array(
                    'id' => $s->getWorkflow()->getId(),
                    'workflow' => $s->getWorkflow()->makeName(),
                    'status' => $s->makeName(),
                    'url' => $s->getWorkflow()->makeURL(),
                    'count' => $count,
                    );
                } catch (Exception $e) {

                }
            }

            $last = true;
            $roleChild = RoleService::Get()->getRoleAll();
            $roleChild->setParentid($x->getId());
            while ($tmp = $roleChild->getNext()) {
                $roleChild2 = RoleService::Get()->getRoleAll();
                $roleChild2->setParentid($tmp->getId());
                if ($tmp2 = $roleChild2->getNext()) {
                    $last = false;
                    break;
                }
            }

            // дочерние роли
            $block = Engine::GetContentDriver()->getContent('structure-block');
            $block->setValue('parentid', $x->getId());
            $render = $block->render();

            $a[] = array(
            'name' => htmlspecialchars($x->getName()),
            'description' => nl2br(htmlspecialchars($x->getDescription())),
            'block_color' => $x->getBlockcolor(),
            'block_structure' => $render,
            'employerArray' => $employerArray,
            'workflowArray' => $workflowArray,
            'count' => $statusCount,
            'last' => $last,
            );
        }
        return $a;
    }

}