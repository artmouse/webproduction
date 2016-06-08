<?php
class faq_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_Faq());
            $id = $this->getArgumentSecure('id');
            if ($id) {
                $form->denyInsert();
            }

            $this->setValue('form', $form->render($id));
            $title = Engine::GetHTMLHead()->getTitle();
            Engine::GetHTMLHead()->setTitle($title.$id);
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}