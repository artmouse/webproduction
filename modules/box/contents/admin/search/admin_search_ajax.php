<?php
class admin_search_ajax extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgumentSecure('name');
            $queryLength = strlen($query);
            if ($queryLength < 3) {
                echo json_encode('badLen');
                exit();
            }

            $limit = 10;
            if ($queryLength > 5) {
                $limit = 50;
            }
            if ($queryLength > 8) {
                $limit = 100;
            }
            if ($queryLength > 10) {
                $limit = 200;
            }

            $boxSearch = Engine::Get()->getConfigFieldSecure('box-search');
            if (!$boxSearch) {
                $boxSearch = array('contact', 'project', 'event', 'issue', 'product', 'document');
            }

            $a = array();

            // поиск контактов
            if (in_array('contact', $boxSearch)) {
                $content = Engine::GetContentDriver()->getContent('shop-admin-search-block-user');
                $content->setValue('query', $query);
                $content->setValue('limit', $limit);
                $a[] = $content->render();
            }

            // поиск проектов
            if (in_array('project', $boxSearch)) {
                $content = Engine::GetContentDriver()->getContent('shop-admin-search-block-order');
                $content->setValue('query', $query);
                $content->setValue('limit', $limit);
                $a[] = $content->render();
            }

            // поиск событий
            if (in_array('event', $boxSearch)) {
                $content = Engine::GetContentDriver()->getContent('shop-admin-search-block-event');
                $content->setValue('query', $query);
                $content->setValue('limit', $limit);
                $a[] = $content->render();
            }

            // поиск задач
            if (in_array('issue', $boxSearch)) {
                $content = Engine::GetContentDriver()->getContent('shop-admin-search-block-issue');
                $content->setValue('query', $query);
                $content->setValue('limit', $limit);
                $a[] = $content->render();
            }

            // поиск продуктов
            if (in_array('product', $boxSearch)) {
                $content = Engine::GetContentDriver()->getContent('shop-admin-search-block-product');
                $content->setValue('query', $query);
                $content->setValue('limit', $limit);
                $a[] = $content->render();
            }

            // поиск документов
            if (in_array('document', $boxSearch) && Shop_ModuleLoader::Get()->isImported('document')) {
                $content = Engine::GetContentDriver()->getContent('shop-admin-search-block-document');
                $content->setValue('query', $query);
                $content->setValue('limit', $limit);
                $a[] = $content->render();
            }

            echo json_encode($a);
        } catch (Exception $e) {
            echo json_encode('error');
        }

        exit;
    }

}