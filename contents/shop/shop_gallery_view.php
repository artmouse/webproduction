<?php
class shop_gallery_view extends Engine_Class {

    public function process() {
        try {
            $gallery = GalleryService::Get()->getGalleryByID(
            $this->getArgument('id')
            );

            if ($gallery->getHidden()) {
                try {
                    if (!$this->getUser()->isAdmin()) {
                        throw new ServiceUtils_Exception();
                    }
                } catch (Exception $e) {
                    throw new ServiceUtils_Exception();
                }
            }

            // устанавливаем meta-ключевые слова и описание
            Engine::GetHTMLHead()->setMetaKeywords(htmlspecialchars($gallery->getSeokeywords()));
            Engine::GetHTMLHead()->setMetaDescription(htmlspecialchars($gallery->getSeodescription()));

            // устанавливаем title
            Engine::GetHTMLHead()->setTitle($gallery->getSeotitle()?$gallery->getSeotitle():$gallery->getName());

            $this->setValue('date', DateTime_Formatter::DateTimePhonetic($gallery->getCdate()));
            $this->setValue('name', htmlspecialchars($gallery->getName()));
            $this->setValue('content', $gallery->getContent());

            // ------------------------------------------------- //

            // SEO-контекнт передаем в shop-tpl
            $tpl = Engine::GetContentDriver()->getContent('shop-tpl');
            $tpl->setValue('seocontent', $gallery->getSeocontent());

            // ------------------------------------------------- //

            // open graph tags
            $image = $gallery->makeImageThumb(100);
            if ($image) {
                Engine::GetHTMLHead()->setMetaTag('og:image', Engine::Get()->getProjectURL().$image);
            }
            Engine::GetHTMLHead()->setMetaTag('og:title', $gallery->getName());
            Engine::GetHTMLHead()->setMetaTag('og:description', htmlspecialchars(strip_tags($gallery->getContent())));

            // ------------------------------------------------- //

            // next and prev links
            try {
                $next = GalleryService::Get()->getGalleryNext($gallery);
                $this->setValue('nextURL', $next->makeURL());
                $this->setValue('nextName', $next->makeName());
            } catch (Exception $galleryEx) {

            }

            try {
                $prev = GalleryService::Get()->getGalleryPrev($gallery);
                $this->setValue('prevURL', $prev->makeURL());
                $this->setValue('prevName', $prev->makeName());
            } catch (Exception $galleryEx) {

            }

            // ------------------------------------------------- //

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}