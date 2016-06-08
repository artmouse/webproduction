<?php
class shop_page_html extends Engine_Class {

    public function process() {
        try {
            // получаем страницу
            $page = Shop::Get()->getTextPageService()->getTextPageByID(
            $this->getArgument('id')
            );

            // получаем путь к html-файлу от корня проекта
            $fileHTML = $page->getKey();
            $fileHTML = trim($fileHTML);

            $fileHTML = PackageLoader::Get()->getProjectPath().$fileHTML;

            if (is_file($fileHTML)) {
                $content = file_get_contents($fileHTML);
                $this->setValue('content', $content);
            }
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