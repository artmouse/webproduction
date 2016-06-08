<?php
class users_groups_control extends Engine_Class {

    public function process() {
        try {
            $groupID = $this->getArgumentSecure('key');
            if ($groupID) {
                $group = Shop::Get()->getUserService()->getUserGroupByID($groupID);

                if ($this->getArgumentSecure('delete')) {
                    try {
                        $group->delete();

                        $url = Engine::GetLinkMaker()->makeURLByContentID('shop-admin-users-groups');
                        header('Location: '.$url);
                        exit();
                    } catch (ServiceUtils_Exception $e) {
                        $this->setValue('message', 'error');
                        $this->setValue('errorsArray', $e->getErrors());
                    }
                }

                if ($this->getArgumentSecure('ok')) {
                    try {
                        $group->setName($this->getControlValue('name'));
                        $group->setDescription($this->getControlValue('description'));
                        $group->setParentid($this->getControlValue('parentid'));
                        $group->setSort($this->getControlValue('sort'));
                        $group->setColour($this->getControlValue('color'));
                        $group->setLogicclass($this->getControlValue('logicclass'));
                        $group->setPricelevel($this->getControlValue('pricelevel'));
                        $group->update();

                        // сохранение полей show/hide
                        $fields = new XShopContactField();
                        $fields->setGroupid($group->getId());
                        while ($x = $fields->getNext()) {
                            if ($this->getArgumentSecure('field'.$x->getId())) {
                                $x->setHidden(0);
                                $x->update();
                            } else {
                                $x->setHidden(1);
                                $x->update();
                            }
                        }

                        $this->setValue('message', 'ok');
                    } catch (ServiceUtils_Exception $e) {
                        $this->setValue('message', 'error');
                        $this->setValue('errorsArray', $e->getErrors());
                    }
                }

                $this->setControlValue('name', $group->getName());
                $this->setControlValue('description', $group->getDescription());
                $this->setControlValue('parentid', $group->getParentid());
                $this->setControlValue('sort', $group->getSort());
                $this->setControlValue('color', $group->getColour());
                $this->setControlValue('logicclass', $group->getLogicclass());
                $this->setControlValue('pricelevel', $group->getPricelevel());

                // список текущий полей
                $fields = new XShopContactField();
                $fields->setGroupid($group->getId());
                $a = array();
                while ($x = $fields->getNext()) {
                    $a[] = array(
                    'name' => $x->getName(),
                    'id' => $x->getId(),
                    'hidden' => $x->getHidden(),
                    'type' => $x->getType(),
                    );
                }
                $this->setValue('fieldArray', $a);

                // текущее дерево групп
                $tree = Shop::Get()->getUserService()->makeUserGroupTree(0);
                $a = array();
                foreach ($tree as $x) {
                    // Пропустить текущую
                    if ($groupID == $x->getId()) {
                        continue;
                    }
                    $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                    'level' => $x->getField('level'),
                    );
                }
                $this->setValue('parentArray', $a);
            } else {
                // это добавление
                $form = new Forms_ContentForm(new Datasource_UserGroup());
                $this->setValue('form', $form->render($groupID));
            }
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}