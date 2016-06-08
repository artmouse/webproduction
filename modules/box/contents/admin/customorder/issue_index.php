<?php
class issue_index extends Engine_Class {

    public function process() {
        $type = $this->getArgumentSecure('type');
        $this->setValue('type', $type);

        $user = $this->getUser();

        if ($user->isDenied($type)) {
            // вычисляем путь к шаблону
            $templateName = Engine::Get()->getConfigFieldSecure('shop-template');
            $templatePath = PackageLoader::Get()->getProjectPath().'/templates/'.$templateName.'/';

            $this->setField('filehtml', $templatePath.'/error/error_deny.html');
            $this->setField('filephp', false);

            $aclName = Shop::Get()->getAclService()->getNameByKey($type);
            LogService::Get()->add(
                array(
                    'url' => Engine_URLParser::Get()->getCurrentURL(),
                    'user #'.$user->getId(),
                    'Acl CONTENT: '.$aclName.' - '.$type
                ),
                'acl'
            );
            return;
        }

        $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true, $type);
        $orders->setType($type);

        if ($type) {
            $url = "/admin/customorder/".$type."/add/";

            $workFlowType = new XShopWorkflowType();
            $workFlowType->setType($type);
            $workFlowType = $workFlowType->getNext();
            if ($workFlowType && $workFlowType->getContentId()) {
                try{
                    $content = Engine_ContentDriver::Get()->getContent(
                        $workFlowType->getContentId()
                    )->getContentData();

                    if ($content['url']) {
                        $url = $content['url'];
                    }
                } catch (Exception $econten) {

                }
            }

            $this->setValue('typeUrl', $url);

            $typeName = Shop::Get()->getShopService()->getTypeName($type);
            $this->setValue('typeName', $typeName);
            Engine::Get()->GetHTMLHead()->setTitle($typeName);
        }

        $list = Engine::GetContentDriver()->getContent('custom-issue-shop-list');
        $list->setValue('issues', $orders);
        $list->setValue('type', $type);
        $this->setValue('block_issue', $list->render());
    }

}