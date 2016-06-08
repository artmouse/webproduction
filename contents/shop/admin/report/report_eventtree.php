<?php
class report_eventtree extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerCSSFile('/_css/jit-base.css');
        PackageLoader::Get()->registerJSFile('/_js/jit-yc.js');

        $datefrom = $this->getArgumentSecure('datefrom', 'date');
        $dateto = $this->getArgumentSecure('dateto', 'date');

        if (!$datefrom) {
            $datefrom = DateTime_Object::Now()->addDay(-3)->setFormat('Y-m-d')->__toString();
            $this->setControlValue('datefrom', $datefrom);
        }

        if (!$dateto) {
            $dateto = DateTime_Object::Now()->setFormat('Y-m-d')->__toString();
            $this->setControlValue('dateto', $dateto);
        }

        // находим все события от или на юзера
        $events = new ShopEvent();
        $events->setOrder('cdate', 'DESC');

        if (!$this->getArgumentSecure('showhidden')) {
            $events->setHidden(0);
        }

        $direction = $this->getControlValue('direction');
        if ($direction == 'in') {
            $events->setDirection(-1);
        } elseif ($direction == 'out') {
            $events->setDirection(+1);
        } elseif ($direction == 'our') {
            $events->setDirection(0);
        }

        $events->addWhere('cdate', $datefrom, '>=');
        $events->addWhere('cdate', $dateto.' 23:59:59', '<=');

        // условия фильтрации
        $from = $this->getControlValue('from');
        if ($from) {
            $events->addWhere('from', '%'.$from.'%', 'LIKE');
        }

        $to = $this->getControlValue('to');
        if ($to) {
            $events->addWhere('to', '%'.$to.'%', 'LIKE');
        }

        $type = $this->getControlValue('type');
        if ($type) {
            $events->setType($type);
        }

        $subject = $this->getControlValue('subject');
        if ($subject) {
            $events->addWhere('subject', '%'.$subject.'%', 'LIKE');
        }

        $content = $this->getControlValue('content');
        if ($content) {
            $events->addWhere('content', '%'.$content.'%', 'LIKE');
        }

        $a = array();
        $nameArray = array();
        while ($x = $events->getNext()) {
            // по полю from определяем юзера
            try {
                $tmp = $x->getFromContact();

                $nameFrom = $tmp->makeName();
                $nameFromID = $tmp->getId();
            } catch (Exception $e) {
                $nameFrom = false;
                $nameFromID = false;
            }

            // по полю to определяем юзера
            try {
                $tmp = $x->getToContact();

                $nameTo = $tmp->makeName();
                $nameToID = $tmp->getId();
            } catch (Exception $e) {
                $nameTo = false;
                $nameToID = false;
            }

            // если ничего не известно - то прячем событие
            // если известно все - показываем
            if (!$nameFrom && !$nameTo) {
                continue;
            }

            if (!$nameFrom) {
                $nameFrom = $x->getFrom();
                $nameFromID = $x->getFrom();
            }
            if (!$nameTo) {
                $nameTo = $x->getTo();
                $nameToID = $x->getTo();
            }

            @$a[$nameFromID][$nameToID] ++;

            $nameArray[$nameFromID] = $nameFrom;
            $nameArray[$nameToID] = $nameTo;
        }

        $json = array();
        foreach ($nameArray as $nameFromID => $nameFrom) {
            $adjacencies = array();
            foreach ($nameArray as $nameToID => $nameTo) {
                if (isset($a[$nameFromID][$nameToID])) {
                    $size = $a[$nameFromID][$nameToID];
                    if ($size >= 10) {
                        $color = 'red';
                    } else {
                        $color = 'gray';
                    }

                    $adjacencies[] = array(
                    'nodeTo' => $nameToID,
                    'nodeFrom' => $nameFromID,
                    'data' => array('$color' => $color /*, '$lineWidth' => $size*/),
                    );
                }
            }

            $isManager = false;
            try {
                $manager = Shop::Get()->getUserService()->getUserByID($nameFromID);
                if ($manager->isAdmin()) {
                    $isManager = true;
                }
            } catch (Exception $e) {

            }

            if ($isManager) {
                $color = 'red';
            } elseif ($nameFromID != $nameFrom) {
                $color = 'blue';
            } else {
                $color = 'gray';
            }

            $json[] = array(
            'id' => $nameFromID,
            'name' => $nameFrom,
            'data' => array(
            '$color' => $color,
            '$type' => "circle",
            '$dim' => 5,
            ),
            'adjacencies' => $adjacencies,
            );
        }

        $json = json_encode($json);
        $this->setValue('json', $json);
    }

}