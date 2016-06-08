<?php
class user_contact_preview extends Engine_Class {

    public function process() {
        try {
            $contact = Shop::Get()->getUserService()->getUserByID(
                $this->getArgument('id')
            );

            $name = $contact->makeName(true, 'lfm');
            $this->setValue('name', $name);
            $this->setValue('company', $contact->getCompany(), true);
            $this->setValue('title', $contact->getPost(), true);

            try {
                $this->setValue('url', $contact->makeURLEdit());
            } catch (Exception $ue) {

            }

            $this->setValue('emailArray', $contact->getEmailArray());
            $this->setValue('phoneArray', $contact->getPhoneArray());
            $this->setValue('address', $contact->getAddress());
            $turboSmsLogin =  Shop::Get()->getSettingsService()->getSettingValue('sms-login');
            $turboSmsPass = Shop::Get()->getSettingsService()->getSettingValue('sms-password');
            $turboSmsSender = Shop::Get()->getSettingsService()->getSettingValue('sms-sender');
            if ($turboSmsLogin && $turboSmsPass && $turboSmsSender) {
                $this->setValue('canSMS', true);
            }

            try {
                $companyObject = Shop::Get()->getShopService()->getCompanyByName($contact->getCompany());
                $this->setValue('logo', $companyObject->makeImageThumb(100, 100));
                $this->setValue('companyURL', $companyObject->makeURLEdit());
            } catch (Exception $e) {

            }

            if ($contact->getImage()) {
                $this->setValue('logo', $contact->makeImageThumb(100, 100));
            }

            // дата последней коммуникации с клиентом
            if ($contact->getActivitydate() && $contact->getActivitydate() != '0000-00-00 00:00:00') {
                $this->setValue('clientactivitydate', $contact->getActivitydate());
            }

            // дополнительные поля контактов
            $userField = new XShopContactField();
            $userField->setShowinpreview(1);
            $userField->setHidden(0);
            $userField->setGroupByQuery('idkey');

            $userFieldArray = array();
            while ($u = $userField->getNext()) {

                $userCustom = new XShopCustomField();
                $userCustom->setObjecttype(get_class($contact));
                $userCustom->setObjectid($contact->getId());
                $userCustom->setKey($u->getIdkey());
                $userCustom = $userCustom->getNext();
                if ($userCustom && $userCustom->getValue()) {
                    $userFieldArray[] = array(
                        'name' => $u->getName(),
                        'key' => $u->getIdkey(),
                        'value' => $userCustom->getValue()
                    );
                }

            }

            $this->setValue('userFieldArray', $userFieldArray);

            // cписок бизнес-процессов
            $isBox = Engine::Get()->getConfigFieldSecure('project-box');
            if ($isBox) {
                $category = Shop::Get()->getShopService()->getWorkflowsActive($this->getUserSecure());
                $category->setHidden(0);

                $dynamicWorkflow = false;
                if (Shop_ModuleLoader::Get()->isModuleInModulesArray('box')
                    && !Engine::Get()->getConfigFieldSecure('static-shop-menu')
                ) {
                    $dynamicWorkflow = true;
                }

                $a = array();
                while ($x = $category->getNext()) {
                    $p = array();
                    $p['workflowid'] = $x->getId();
                    $p['clientid'] = $contact->getId();
                    $p['clientname'] = $contact->makeName();

                    $typeWorkflow = $x->getType();
                    if (!$typeWorkflow) {
                        $typeWorkflow = 'order';
                    }

                    if ($dynamicWorkflow) {
                        $url = '/admin/customorder/'.$typeWorkflow.'/add/';
                    } else {
                        $url = '/admin/'.$typeWorkflow.'/add/';
                    }

                    $url .= '?';

                    foreach ($p as $foreachKey => $foreachValue) {
                        if (!$foreachKey || !$foreachValue) {
                            continue;
                        }
                        $url.=$foreachKey.'='.$foreachValue.'&';
                    }

                    $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                    'url' => $url,
                    );
                }
                $this->setValue('workflowArray', $a);
            }

            /*$currency = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $this->setValue('balance', $contact->makeBalance($currency));
            $this->setValue('currency', $currency->getSymbol());*/

        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }
}