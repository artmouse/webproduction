<?php
class comment_template_add extends Engine_Class {

    public function process() {
        try{
            if ($this->getArgumentSecure('ok')) {
                try{
                    $ex = new ServiceUtils_Exception();

                    $name = $this->getArgumentSecure('name');
                    if (!$name) {
                        $ex->addError('name');
                    }

                    if ($ex->getErrorsArray()) {
                        throw $ex;
                    }

                    $comment = new XShopCommentTemplate();
                    $comment->setName($this->getControlValue('name'));
                    $comment->setText($this->getControlValue('text'));
                    $comment->insert();
                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $ex) {
                    $this->setValue('message', 'error');
                }

            }
        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}