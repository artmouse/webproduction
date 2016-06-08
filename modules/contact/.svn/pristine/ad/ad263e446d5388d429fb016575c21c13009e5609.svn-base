<?php
class users_legal extends Engine_Class {

    public function process() {
        try {
            $user = Shop::Get()->getUserService()->getUserByID(
            $this->getArgument('id')
            );

            if (!Shop::Get()->getUserService()->isUserChangeAllowed($user, $this->getUser())) {
                throw new ServiceUtils_Exception('user');
            }

            Engine::GetHTMLHead()->setTitle($user->makeName());

            $menu = Engine::GetContentDriver()->getContent('shop-admin-users-menu');
            $menu->setValue('selected', 'legal');
            $menu->setValue('userid', $user->getId());
            $this->setValue('menu', $menu->render());

            $deleteID = $this->getArgumentSecure('delete');
            if ($deleteID) {
                try {
                    SQLObject::TransactionStart();

                    $legalObject = new XShopUserLegal($deleteID);
                    $legalObject->delete();

                    $legalObjectData = new XShopUserLegalData();
                    $legalObjectData->setLegalid($deleteID);
                    while ($x = $legalObjectData->getNext()) {
                        $x->delete();
                    }

                    SQLObject::TransactionCommit();

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $e) {
                    SQLObject::TransactionRollback();

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrors());
                }
            }

            if ($this->getArgumentSecure('ok')) {
                try {
                    SQLObject::TransactionStart();

                    $format = $this->getArgument('format');
                    if (!$format) {
                        throw new ServiceUtils_Exception();
                    }

                    $name = trim($this->getArgument($format.'-name'));

                    $legalObject = new XShopUserLegal();
                    $legalObject->setUserid($user->getId());
                    $legalObject->setFormat($format);
                    $legalObject->setName($name);
                    $legalObject->insert();

                    $formatArray = Engine::Get()->getConfigField('legalFormatArray');
                    $formatArray = $formatArray[$format];

                    foreach ($formatArray as $key => $value) {
                        $legalObjectData = new XShopUserLegalData();
                        $legalObjectData->setLegalid($legalObject->getId());
                        $legalObjectData->setKey($key);
                        $legalObjectData->setName($value);
                        $legalObjectData->setValue($this->getArgument($format.'-'.$key));
                        $legalObjectData->insert();
                    }

                    SQLObject::TransactionCommit();

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $e) {
                    SQLObject::TransactionRollback();

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrors());
                }
            }

            // список юридических реквизитов
            $legal = new XShopUserLegal();
            $legal->setUserid($user->getId());
            $a = array();
            while ($x = $legal->getNext()) {
                $b = array();
                $data = new XShopUserLegalData();
                $data->setLegalid($x->getId());
                while ($d = $data->getNext()) {
                    $b[] = array(
                    'name' => $d->getName(),
                    'value' => $d->getValue(),
                    );
                }

                $a[] = array(
                'name' => $x->getName(),
                'format' => $x->getFormat(),
                'detailArray' => $b,
                'urldelete' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('delete' => $x->getId())),
                );
            }
            $this->setValue('legalArray', $a);

            // форма добавления реквизитов
            $formatArray = Engine::Get()->getConfigField('legalFormatArray');
            $this->setValue('formatArray', $formatArray);

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}