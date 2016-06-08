<?php
class report_contacttree extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerCSSFile('/_css/jit-base.css');
        PackageLoader::Get()->registerJSFile('/_js/jit-yc.js');

        $datefrom = $this->getArgumentSecure('datefrom', 'date');
        $dateto = $this->getArgumentSecure('dateto', 'date');

        $contacts = Shop::Get()->getUserService()->getUsersAll();

        if ($datefrom) {
            $contacts->addWhere('cdate', $datefrom, '>=');
        }
        if ($dateto) {
            $contacts->addWhere('cdate', $dateto.' 23:59:59', '<=');
        }

        $a = array();
        $b = array();
        $nameArray = array();
        while ($x = $contacts->getNext()) {
            $nameArray[$x->getId()] = $x->makeName();

            if ($x->getParentid()) {
                $a[$x->getParentid()][$x->getId()] = 1;
                $b[$x->getId()][$x->getParentid()] = 1;
            }
        }

        $json = array();
        foreach ($nameArray as $nameFromID => $nameFrom) {
            if (empty($a[$nameFromID]) && empty($b[$nameFromID])) {
                continue;
            }

            $adjacencies = array();
            foreach ($nameArray as $nameToID => $nameTo) {
                if (isset($a[$nameFromID][$nameToID])) {
                    $adjacencies[] = array(
                    'nodeTo' => $nameToID,
                    'nodeFrom' => $nameFromID,
                    'data' => array('$color' => 'gray'),
                    );
                }
            }

            $isManager = false;
            $url = false;
            try {
                $manager = Shop::Get()->getUserService()->getUserByID($nameFromID);
                $url = $manager->makeURLEdit();

                if ($manager->isAdmin()) {
                    $isManager = true;
                }
            } catch (Exception $e) {

            }

            if ($isManager) {
                $color = 'red';
            } else {
                $color = 'blue';
            }

            $json[] = array(
            'id' => $nameFromID,
            'name' => $nameFrom,
            'url' => $url,
            'data' => array(
            '$color' => $color,
            '$type' => "circle",
            '$dim' => 5,
            ),
            'adjacencies' => $adjacencies,
            );
        }

        $size = count($json) * 3;
        if ($size <= 600) {
        	$size = 600;
        }
        $this->setValue('size', $size);

        $json = json_encode($json);
        $this->setValue('json', $json);
    }

}