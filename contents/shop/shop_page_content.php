<?php
class shop_page_content extends Engine_Class {

    public function process() {
        try {
            // получаем страницу
            $page = Shop::Get()->getTextPageService()->getTextPageByID(
            $this->getArgument('id')
            );

            // получаем контент
            $contentID = $page->getKey();
            $contentID = trim($contentID);

            $content = Engine::GetContentDriver()->getContent($contentID);
            $this->setValue('content', $content->render());
        } catch (Exception $ge) {
            if (method_exists($ge, 'log')) {
            	$ge->log();
            }

            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}