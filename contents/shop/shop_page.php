<?php
class shop_page extends Engine_Class {

    public function process() {
        try {
            $page = Shop::Get()->getTextPageService()->getTextPageByID(
                $this->getArgument('id')
            );

            // скрытые показываем только админу
            if ($page->getHidden()) {
                if (!$this->getUserSecure()) {
                    throw new ServiceUtils_Exception('hidden');
                }
            }

        } catch (Exception $e) {
            // бросаем exception для 404
            $e->setCode(404);
            throw $e;
        }

        // скрытые страницы видит только админ
        if ($page->getHidden()) {
            if (!$this->getUser()->isAdmin()) {
                throw new ServiceUtils_Exception();
            }
        }

        try {
            if ($this->getUser()->isAdmin()) {
                $this->
                setValue(
                    'urledit',
                    Engine::GetLinkMaker()->makeURLByContentIDParam(
                        'shop-admin-textpages',
                        $page->getId(),
                        'open'
                    )
                );
            }
        } catch (Exception $e) {

        }

        // устанавливаем meta-ключевые слова и описание
        Engine::GetHTMLHead()->setMetaKeywords(htmlspecialchars($page->getSeokeywords()));
        Engine::GetHTMLHead()->setMetaDescription(htmlspecialchars($page->getSeodescription()));

        // устанавливаем title
        Engine::GetHTMLHead()->setTitle($page->getSeotitle()?$page->getSeotitle():$page->getName());

        $this->setValue('content', $page->getContent());
        $this->setValue('name', $page->getName());

        // SEO-контекнт передаем в shop-tpl
        $tpl = Engine::GetContentDriver()->getContent('shop-tpl');
        $tpl->setValue('seocontent', $page->getSeocontent());

        // logicclass
        $contentID = $page->getLogicclass();
        if ($contentID) {
            $content = Engine::GetContentDriver()->getContent($contentID);
            $this->setValue('logiccontent', $content->render());
        }
    }

}