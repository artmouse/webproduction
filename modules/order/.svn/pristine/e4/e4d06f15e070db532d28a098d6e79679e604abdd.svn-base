<?php
class users_json_autocomplete_select2 extends Engine_Class {

    public function process() {
        try {
            $pageNum = $this->getArgumentSecure('pageNum');
            $pageSize = $this->getArgumentSecure('pageSize');
            $arrUserId = $this->getArgumentSecure('arrUserId');
            $searchTerm = $this->getArgumentSecure('searchTerm');

            $a = array();
            if ($searchTerm) {
                $users = Shop::Get()->getUserService()->searchUsers($searchTerm, $this->getUser());
                $count = $users->getCount();
            } else {
                $users = Shop::Get()->getUserService()->getUsersAll($this->getUser());
                $count = 1000000;
            }

            $users->addWhere('typesex', 'company', '!=');

            $users->setLimit(($pageNum-1)*$pageSize, $pageSize);

            $companyArray = array();
            $usersIdArray = explode(';', $arrUserId);

            while ($x = $users->getNext()) {
                if (in_array($x->getId(), $usersIdArray)) {
                    continue;
                }
                $a[] = array(
                'id' => $x->getId(),
                'text' => htmlspecialchars($x->makeName(true, true, false, true))
                );

                if ($x->getCompany()) {
                    $companyArray[$x->getCompany()] = $x->getCompany();
                }
            }

            echo json_encode(
                array(
                    'Results' => $a,
                    'Total' => $count
                )
            );

        } catch (Exception $e) {

        }

        exit();
    }

}