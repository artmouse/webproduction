<?php
class custom_issue_add extends Engine_Class {

    public function process() {
        $type = $this->getArgument('type');
        $typeObject = new XShopWorkflowType();
        $typeObject->setType($type);
        $typeObject = $typeObject->getNext();
        if ($typeObject) {
            $typeAddPage = $typeObject->getTypeaddpage();
            if (!$typeAddPage) {
                $typeAddPage = 'issue';
            }
            $content = Engine::GetContentDriver()->getContent('custom-'.$typeAddPage.'-add');
            $this->setValue('html', $content->render());
        } else {
            Engine::Get()->getRequest()->setContentNotFound();
        }

    }

}