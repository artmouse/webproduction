<?php
class workflow_edit extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/jsPlumb.js');

        try {
            $isBox = Engine::Get()->getConfigFieldSecure('project-box');
            $this->setValue('box', $isBox);

            $workflowVisualEnable = Engine::Get()->getConfigFieldSecure('workflow-visual-enable');
            $this->setValue('workflowVisualEnable', $workflowVisualEnable);

            $dynamicWorkflow = false;
            if (Shop_ModuleLoader::Get()->isModuleInModulesArray('box')
                && !Engine::Get()->getConfigFieldSecure('static-shop-menu')
            ) {
                $dynamicWorkflow = true;
            }
            $this->setValue('dynamic_workflow_menu', $dynamicWorkflow);

            // set workflow name as title
            $curWorkflow = WorkflowService::Get()->getWorkflowByID($this->getArgumentSecure('id'));
            Engine_HTMLHead::Get()->setTitle($curWorkflow->makeName());

            $category = Shop::Get()->getShopService()->getOrderCategoryByID(
                $this->getArgument('id')
            );

            // Бизнесс-процесс по умолчанию.
            $default = Shop::Get()->getShopService()->getOrderCategoryAll();
            $default->setDefault(1);
            $default->setType($category->getType());
            if ($default->select()) {
                $this->setValue('confirmDefault', $default->getId());
            }

            // сохранение формы
            if ($this->getArgumentSecure('send_edit')) {
                try {
                    // редактирование имени workflow'a
                    $name = @trim($this->getArgumentSecure('name', 'string'));
                    if ($name) {
                        $category->setName($name);
                    }

                    $term = (int) $this->getControlValue('term');
                    if ($term < -1) {
                        $term = 0;
                    }

                    $controlDefault = $this->getArgumentSecure('workflowdefault');

                    if ($default && $controlDefault) {
                        $tmp = Shop::Get()->getShopService()->getOrderCategoryAll();
                        $tmp->setDefault(1);
                        $tmp->setType($this->getArgumentSecure('type'));
                        while ($x = $tmp->getNext()) {
                            $x->setDefault(0);
                            $x->update();
                        }
                    }

                    $type = $this->getArgumentSecure('type');
                    if (!$type) {
                        $type = 'order';
                    }

                    if ($type != $category->getType()) {
                        $category->setChangeType(1);
                    }

                    $category->setDefault($controlDefault);
                    $category->setHidden($this->getArgumentSecure('hidden'));
                    $category->setType($type);
                    $category->setTerm($term);
                    $category->setColorMenu($this->getArgumentSecure('color_menu'));
                    $category->setManagerid($this->getArgumentSecure('managerid'));
                    $category->setIssuename($this->getArgumentSecure('issuename'));
                    $category->setCurrencyid($this->getArgumentSecure('currency'));
                    $category->setOutcoming($this->getArgumentSecure('outcoming'));
                    $category->setKeywords($this->getArgumentSecure('keywords'));

                    $category->setNoautodateto($this->getArgumentSecure('noautodateto'));

                    // список продуктов
                    $str = '';
                    if (preg_match_all("/#([\d\w\pL]+)/ius", $this->getArgumentSecure('productlist'), $r)) {
                        foreach ($r[1] as $productID) {
                            if (!$productID) {
                                continue;
                            }
                            if ($str) {
                                $str.= ','.$productID;
                            } else {
                                $str = $productID;
                            }
                        }
                    }
                    $category->setProductsDefault($str);
                    $category->update();

                    $e = $category->getStatuses();

                    // редактирование каждого элемента workflow
                    while ($x = $e->getNext()) {
                        if ($this->getArgumentSecure("delete_{$x->getId()}")) {
                            // переключаем все заказы с этого статуса на default
                            $orders = new ShopOrder();
                            $orders->setStatusid($x->getId());
                            $orders->setDateclosed('0000-00-00 00:00:00');                          
                            while ($order = $orders->getNext()) {
                                try{                                   
                                    Shop::Get()->getShopService()->updateOrderStatus(
                                        $this->getUser(),
                                        $order,
                                        $x->getWorkflow()->getStatusDefault()->getId()
                                    );
                                } catch (Exception $oe) {

                                }

                            }
                            $x->delete();
                        } else {
                            // обновляем элемент workflow'a
                            $x->setName($this->getArgument('name_'.$x->getId()));
                            if ($isBox) {
                                $x->setContent($this->getArgument('description_'.$x->getId()));
                                $x->setRoleid($this->getArgumentSecure('role_'.$x->getId()));
                            }
                            $x->setColour($this->getArgument('colour_'.$x->getId()));
                            $x->setSort($this->getArgument('sort_'.$x->getId()));
                            $x->setDefault($this->getArgumentSecure("default") == $x->getId());
                            //$x->setSaled($this->getArgumentSecure('saled_'.$x->getId()));
                            //$x->setPayed($this->getArgumentSecure('payed_'.$x->getId()));
                            //$x->setTerm($this->getArgumentSecure('term_'.$x->getId()));
                            //$x->setTermperiod($this->getArgumentSecure('period_'.$x->getId()));
                            $x->update();
                        }
                    }



                    $this->setValue('edit_ok', true);
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('error_edit', $e->getErrors());
                }

                // добавление элемента
                $name = $this->getArgumentSecure('element_name');
                $nameArray = explode("\n", $name);
                foreach ($nameArray as $name) {
                    $name = trim($name);
                    if (!$name) {
                        continue;
                    }

                    try {
                        $x = new ShopOrderStatus();
                        $x->setCategoryid($category->getId());
                        $x->setOrder('sort', $type = 'DESC');
                        $x->setLimitCount(1);
                        $s = $x->getNext();

                        $default = false;
                        if ($s) {
                            $maxSort = $s->getSort();
                            $maxSort++;
                        } else {
                            $default = true;
                            $maxSort = 1;
                        }

                        $x = new ShopOrderStatus();
                        $x->setCategoryid($category->getId());
                        $x->setSort($maxSort);
                        $x->setName($name);
                        //$x->setContent($this->getArgumentSecure('element_description'));
                        //$x->setRole($this->getArgumentSecure('element_role'));
                        //$x->setTermperiod($this->getArgumentSecure('element_period'));
                        //$x->setTerm($this->getArgumentSecure('element_term'));
                        $x->setDefault($default);
                        $x->insert();

                        $this->setValue('edit_ok', true);
                    } catch (Exception $e) {
                        $this->setValue('error_add', true);
                    }
                }

                try {
                    $statuses = $category->getStatuses();

                    $elementsFrom = $statuses->toArray();
                    $elementsTo = $elementsFrom;
                    foreach ($elementsFrom as $eFrom) {
                        // получаем элемент
                        $elementObject = Shop::Get()->getShopService()->getStatusByID($eFrom['id']);

                        // сохраняем позицию и размеры элемента
                        $elementObject->setX($this->getArgumentSecure('position_'.$eFrom['id'].'_x'));
                        $elementObject->setY($this->getArgumentSecure('position_'.$eFrom['id'].'_y'));
                        $elementObject->setWidth($this->getArgumentSecure('position_'.$eFrom['id'].'_width'));
                        $elementObject->setHeight($this->getArgumentSecure('position_'.$eFrom['id'].'_height'));
                        $elementObject->update();

                        // сохраняем возможные переходы из одного статуса в другой
                        foreach ($elementsTo as $eTo) {
                            if ($this->getArgumentSecure('change'.$eFrom['id'].'_'.$eTo['id'])) {
                                $change = new XShopOrderStatusChange();
                                $change->setCategoryid($category->getId());
                                $change->setElementfromid($eFrom['id']);
                                $change->setElementtoid($eTo['id']);
                                if (!$change->select()) {
                                    $change->insert();
                                }
                            } else {
                                $change = new XShopOrderStatusChange();
                                $change->setCategoryid($category->getId());
                                $change->setElementfromid($eFrom['id']);
                                $change->setElementtoid($eTo['id']);
                                if ($change->select()) {
                                    $change->delete();
                                }
                            }
                        }
                    }

                    $this->setValue('edit_ok', true);
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('error_add', $e->getErrorsArray());
                }
            }

            $e = Shop::Get()->getShopService()->getStatusAll();
            $e->setCategoryid($category->getId());
            $ea = array();
            while ($x = $e->getNext()) {
                $urlInterface = false;

                if ($isBox) {
                    $urlInterface = Engine::GetLinkMaker()->makeURLByContentIDParam(
                        'box-workflow-status-interface',
                        $x->getId()
                    );
                }

                $ea[] = array(
                    'id' => $x->getId(),
                    'name' => htmlspecialchars($x->getName()),
                    'description' => htmlspecialchars($x->getContent()),
                    'default' => $x->getDefault(),
                    'positionx' => $x->getX(),
                    'positiony' => $x->getY(),
                    'width' => $x->getWidth(),
                    'height' => $x->getHeight(),
                    'colour' => $x->getColour(),
                    'saled' => $x->getSaled(),
                    'payed' => $x->getPayed(),
                    'sort' => $x->getSort(),
                    'term' => $x->getTerm(),
                    'period' => $x->getTermperiod(),
                    'roleid' => $x->getRoleid(),
                    'urlEdit' => Engine::GetLinkMaker()->makeURLByContentIDParam(
                        'shop-workflow-status-edit',
                        $x->getId()
                    ),
                    'urlInterface' => $urlInterface,
                    'urlAction' => $urlAction = Engine::GetLinkMaker()->makeURLByContentIDParam(
                        'shop-workflow-status-action-new',
                        $x->getId()
                    )
                );
            }

            $this->setValue('elementArray', $ea);
            $this->setValue('elementsCount', count($ea));

            // переходы статусов
            $changes = new XShopOrderStatusChange();
            $changes->setCategoryid($category->getId());
            $changes->setOrderBy('elementfromid');
            $changesArray = array();
            while ($change = $changes->getNext()) {
                $changesArray[$change->getElementfromid()][$change->getElementtoid()] = 1;
            }
            $this->setValue('changesArray', $changesArray);

            $this->setValue('name', $category->makeName());
            $this->setValue('categoryid', $category->getId());
            $this->setControlValue('workflowdefault', $category->getDefault());
            $this->setControlValue('outcoming', $category->getOutcoming());
            $this->setControlValue('noautodateto', $category->getNoautodateto());

            if ($isBox) {
                $this->setValue('issue', $category->getType() == 'issue');
                $this->setValue('project', $category->getType() == 'project');
                $this->setValue('call', $category->getType() == 'call');
                $this->setValue('email', $category->getType() == 'email');

                $this->setControlValue('hidden', $category->getHidden());
                $this->setControlValue('issuename', $category->getIssuename());
                $this->setControlValue('managerid', $category->getManagerid());
                $this->setControlValue('term', $category->getTerm());
                $this->setControlValue('color_menu', $category->getColorMenu());
                $this->setControlValue('keywords', $category->getKeywords());

                $currencyAll = Shop::Get()->getCurrencyService()->getCurrencyAll();
                $currencyAll->setHidden(0);
                $currencyId = $category->getCurrencyid();

                $currencyArray = array();
                while ($x = $currencyAll->getNext()) {
                    $currencyArray[] = array(
                        'id' => $x->getId(),
                        'name' => $x->getName(),
                        'selected' => $x->getId() == $currencyId ? true : false
                    );
                }
                $this->setValue('currencyArray', $currencyArray);

                $managers = Shop::Get()->getUserService()->getUsersManagers();
                $a = array();
                while ($x = $managers->getNext()) {
                    $a[] = array(
                        'id' => $x->getId(),
                        'name' => $x->makeName(true, 'lfm'),
                    );
                }
                $this->setValue('managerArray', $a);

                $this->setValue('roleArray', RoleService::Get()->makeRoleListArray());

                $workflowTypeArray = array();
                $workflowType = new XShopWorkflowType();
                while ($x = $workflowType->getNext()) {
                    $workflowTypeArray[] = array(
                        'name' => $x->getName(),
                        'type' => $x->getType(),
                        'selected' => $category->getType() == $x->getType() ? true:false
                    );
                }

                $this->setValue('workflowTypeArray', $workflowTypeArray);

                $productsArray = explode(',', $category->getProductsDefault());
                $productsDefaultArray = array();
                foreach ($productsArray as $prodId) {
                    if (!$prodId) {
                        continue;
                    }

                    try{
                        $product = Shop::Get()->getShopService()->getProductByID($prodId);
                        $str = '#'.$prodId.' '.$product->getName();
                        $productsDefaultArray[] = $str;
                    } catch (Exception $e) {

                    }

                }
                $this->setValue('productsDefaultArray', $productsDefaultArray);



            }

        } catch (Exception $ge) {
            print $ge;
        }

    }

}