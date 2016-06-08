<?php
class shop_page extends Engine_Class {

    public function process() {
        header('Cache-Control: max-age=3600, must-revalidate');
        header('Expires: access plus 3600 seconds');
        header('Pragma:cache');

        try {
            $page = Shop::Get()->getTextPageService()->getTextPageByID(
                $this->getArgument('id')
            );

            // скрытые страницы видит только админ
            if ($page->getHidden()) {
                if (!$this->getUser()->isAdmin()) {
                    throw new ServiceUtils_Exception();
                }
            }

            try {
                if ($this->getUser()->isAdmin()) {
                    $this->setValue(
                        'urledit',
                        Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-textpages', $page->getId(), 'open')
                    );
                }
            } catch (Exception $e) {

            }

            Engine::GetHTMLHead()->addLink('canonical', $page->makeURL());

            // устанавливаем meta-ключевые слова и описание
            Engine::GetHTMLHead()->setMetaKeywords(htmlspecialchars($page->getSeokeywords()));
            Engine::GetHTMLHead()->setMetaDescription(htmlspecialchars($page->getSeodescription()));
            $this->setValue('seoh1', $page->getSeoh1());

            // устанавливаем title
            Engine::GetHTMLHead()->setTitle($page->getSeotitle() ? $page->getSeotitle() : $page->getName());

            $this->setValue('content', $page->getContent());
            $this->setValue('name', $page->getName());

            // SEO-контекнт передаем в shop-tpl
            $tpl = Engine::GetContentDriver()->getContent('shop-tpl');
            $tpl->setValue('seocontent', $page->getSeocontent());

            $pathArray = $this->_makePathArray($page);
            $pathArray = array_reverse($pathArray);
            $this->setValue('pathArray', $pathArray);

            // logicclass
            $contentID = $page->getLogicclass();
            if ($contentID) {
                $content = Engine::GetContentDriver()->getContent($contentID);
                $content->setValue('pageid', $page->getId());
                $this->setValue('logiccontent', $content->render());
                $this->setValue('contentID', $contentID);

                if ($contentID = 'shop-news') {
                    $news = Shop::Get()->getNewsService()->getNewsAll();
                    $news->setHidden(0);
                    $news->setLimitCount(5);
                    $a = array();
                    while ($n = $news->getNext()) {
                        $a[] = array(
                            'id' => $n->getId(),
                            'name' => $n->makeName(),
                            'date' => DateTime_Formatter::DateRussianGOST($n->getCdate()),
                            'url' => $n->makeURL(),
                        );
                    }
                    $this->setValue('newsArray', $a);
                }
            }

        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();

            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
    }

    private function _makePathArray(ShopTextPage $page) {
        $a = array();
        $a[] = array(
            'name' => $page->getName(),
            'url' => $page->makeURL(),
        );
        try {
            $parent = Shop::Get()->getTextPageService()->getTextPageByID($page->getParentid());
            $a = array_merge($a, $this->_makePathArray($parent));
        } catch (Exception $e) {

        }

        return $a;
    }

}