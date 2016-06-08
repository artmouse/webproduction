<?php
class comment_template_control extends Engine_Class {

    public function process() {
        try{
            $comment = new XShopCommentTemplate($this->getArgument('id'));

            if ($this->getArgumentSecure('del')) {
                $comment->delete();
                header('Location: /admin/comment/template/');
            }

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

                    $comment->setName($this->getControlValue('name'));
                    $comment->setText($this->getControlValue('text'));
                    $comment->update();

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $ex) {
                    $this->setValue('message', 'error');
                }

            }

            $this->setValue('id', $comment->getId());
            $this->setControlValue('name', $comment->getName());
            $this->setControlValue('text', $comment->getText());
        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}