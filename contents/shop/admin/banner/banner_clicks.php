<?php
class banner_clicks extends Engine_Class {

    public function process() {
        try {
            $banner = Shop::Get()->getShopService()->getBannerByID(
                $this->getArgument('id')
            );

            if (!$this->getArgumentSecure('ok')) {
                $datefrom = DateTime_Formatter::DateISO9075(DateTime_Object::Now()->addMonth(-1));
                $dateto = DateTime_Formatter::DateISO9075(DateTime_Object::Now());
                $this->setControlValue('dateFrom', $datefrom);
                $this->setControlValue('dateTo', $dateto);
            }

            $this->setValue('bannerid', $banner->getId());
            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_banner_').$banner->getId()
            );

            $views = new XShopBannerStatistics();
            $views->setBannerid($banner->getId());
            $views->setOrder('cdate', 'DESC');
            if ($this->getControlValue('dateFrom')) {
                $datefrom = DateTime_Corrector::CorrectDateTime($this->getControlValue('dateFrom'));
                $views->addWhere('cdate', $datefrom, '>=');
            }
            if ($this->getControlValue('dateTo')) {
                $dateto = DateTime_Corrector::CorrectDateTime($this->getControlValue('dateTo').' 23:59:59');
                $views->addWhere('cdate', $dateto, '<=');
            }
            $a = array();
            while ($x = $views->getNext()) {
                try {
                    $user = Shop::Get()->getUserService()->getUserByID($x->getUserid())->makeInfoArray();
                } catch (Exception $e) {
                    $user = false;
                }

                $a[] = array(
                'cdate' => $x->getCdate(),
                'user' => $user,
                'sessionid' => $x->getSessionid(),
                'ip' => $x->getIp(),
                );
            }
            $this->setValue('viewsArray', $a);


            $b = array();
            $datebiff = DateTime_Differ::DiffDay($dateto, $datefrom);
            if ($datebiff >= 60) {
                $datebiff = DateTime_Differ::DiffMonth($dateto, $datefrom);
                for ($i=$datebiff; $i >= 0; $i--) {
                    $d = DateTime_Object::FromString(
                        DateTime_Object::Now()->addMonth(-$i)->__toString()
                    )->setFormat('Y-m')->__toString();
                    $b[$d] = array(
                    'date' => $d,
                    'cnt' => 0
                    );
                }
                $views->addFieldQuery("DATE_FORMAT(`cdate`,'%Y-%m') as 'dd', COUNT(*) as 'cnt'");
            } elseif ($datebiff == 1) {
                for ($i=24; $i >= 0; $i--) {
                    $d = DateTime_Object::FromString(
                        DateTime_Object::Now()->addHour(-$i)->__toString()
                    )->setFormat('Y-m-d H')->__toString();
                    $b[$d] = array(
                        'date' => $d,
                        'cnt' => 0
                    );
                }
                $views->addFieldQuery("DATE_FORMAT(`cdate`,'%Y-%m-%d %H') as 'dd', COUNT(*) as 'cnt'");
            } else {
                for ($i=$datebiff; $i >= 0; $i--) {
                    $d = DateTime_Object::FromString(
                        DateTime_Object::Now()->addDay(-$i)->__toString()
                    )->setFormat('Y-m-d')->__toString();
                    $b[$d] = array(
                    'date' => $d,
                    'cnt' => 0
                    );
                }
                $views->addFieldQuery("DATE(`cdate`) as 'dd', COUNT(*) as 'cnt'");
            }
            $views->setGroupByQuery("(`dd`)");
            $views->setOrder('cdate', 'ASC');
            while ($f = $views->getNext()) {
                $b[$f->getField('dd')]=array(
                'date' => $f->getField('dd'),
                'cnt' => $f->getField('cnt')
                );
            }
            if (isset($b)) {
                $this->setValue('viewArray', $b);
            }

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}