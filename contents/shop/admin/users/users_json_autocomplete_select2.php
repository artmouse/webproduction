<?php
class users_json_autocomplete_select2 extends Engine_Class {

    public function process() {
        try {
            $searchTerm = $this->getArgument('searchTerm');
            $pageNum = $this->getArgument('pageNum');
            $pageSize = $this->getArgument('pageSize');
            $callback = $this->getArgument('callback');

            $a = array();
            if ($searchTerm) {
                $users = Shop::Get()->getUserService()->searchUsers($searchTerm, $this->getUser());
                $count = $users->getCount();
            } else {
                $users = Shop::Get()->getUserService()->getUsersAll($this->getUser());
                $count = 1000000;
            }

            $searchCompany = true;

            if ($this->getArgumentSecure('searchin') == 'order') {
                $users->addWhereQuery('(`id` IN (SELECT `userid` FROM `shoporder` WHERE issue=0))');
            } elseif ($this->getArgumentSecure('searchin') == 'project') {
                $users->addWhereQuery('(`id` IN (SELECT `userid` FROM `shoporder` WHERE parentid=0))');
            } elseif ($this->getArgumentSecure('searchin') == 'issue') {
                $users->addWhereQuery('(`id` IN (SELECT `userid` FROM `shoporder` WHERE parentid>0))');
            } elseif ($this->getArgumentSecure('searchin') == 'financepayment_client'
                && Shop_ModuleLoader::Get()->isImported('finance')
            ) {
                $users->addWhereQuery('(`id` IN (SELECT `clientid` FROM `financepayment`))');
            } elseif ($this->getArgumentSecure('searchin') == 'financepayment_manager'
                && Shop_ModuleLoader::Get()->isImported('finance')
            ) {
                $searchCompany = false;
                $users->addWhereQuery('(`id` IN (SELECT `userid` FROM `financepayment`))');
            } elseif ($this->getArgumentSecure('searchin') == 'userto') {
                $searchCompany = false;
                $users->addWhere('typesex', 'company', '!=');
            }

            $users->setLimit(($pageNum-1)*$pageSize, $pageSize);

            $companyArray = array();

            while ($x = $users->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'text' => htmlspecialchars($x->makeName())
                );

                if ($x->getCompany()) {
                    $companyArray[$x->getCompany()] = $x->getCompany();
                }
            }

            if ($searchCompany) {
                foreach ($companyArray as $companyName) {
                    try {
                        $company = Shop::Get()->getShopService()->getCompanyByName($companyName);
                        $a[] = array(
                            'id' => $company->getId(),
                            'text' =>
                                Shop::Get()->getTranslateService()->getTranslateSecure('translate_kompaniya_').
                                $companyName
                        );
                    } catch (Exception $e) {

                    }

                }
            }


            echo $callback . '(' . json_encode(
                array(
                    'Results' => $a,
                    'Total' => $count
                )
            ) .')';

        } catch (Exception $e) {

        }

        exit();
    }

}