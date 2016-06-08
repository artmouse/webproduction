<?php
class standard_tpl extends Engine_Class {

    public function process() {

        $user = Shop::Get()->getUserService()->getUser();

        $access = false;
        if ($user->isAllowed('control-standard')) {
            $access = true;
        }
        if ($user->getLevel() >= 3) {
            $access = true;
        }
        $this->setValue('acl', $access);

        $link = $this->getArgumentSecure('id');
        $this->setValue('choice', $link);

        $linkEdit = Engine::GetLinkMaker()->makeURLByContentIDParam('admin-standard-edit', $link);
        $linkCreate = Engine::GetLinkMaker()->makeURLByContentID('admin-standard-create');
        $this->setValue('linkedit', $linkEdit);
        $this->setValue('linkcreate', $linkCreate);

        $content = new XShopStandard($link);
        $this->setValue('content', $content->getContent());

        $author = new User($content->getCauthorid());
        $this->setValue('cauthor', $author->makeName());
        $this->setValue('authorDataId', $author->getId());
        $this->setValue('urlViewAuthor', $author->makeURLEdit());

        $cd = DateTime_Formatter::DateTimeRussianGOST($content->getCdate());
        $this->setValue('cdate', $cd);

        $mauthor = new User($content->getMauthorid());
        $this->setValue('mauthor', $mauthor->makeName());
        $this->setValue('mauthorDataId', $mauthor->getId());
        $this->setValue('urlViewMauthor', $mauthor->makeURLEdit());

        $md = DateTime_Formatter::DateTimeRussianGOST($content->getMdate());
        $this->setValue('mdate', $md);

        $this->setValue('control_text', $content->getContent());
        $this->setValue('control_name', $content->getName());

        // фильтр по автору
        $cauthorArray = array();
        $filterCauthor = new XShopStandard();
        $filterCauthor->setGroupByQuery('cauthorid');
        while ($x = $filterCauthor->getNext()) {
            try {
                $user = Shop::Get()->getUserService()->getUserByID($x->getCauthorid());
                $cauthorArray[] = array(
                    'id' => $x->getCauthorid(),
                    'name' => $user->makeName()
                );
            } catch (Exception $e) {

            }
        }
        $this->setValue('cauthorArray', $cauthorArray);

        // фильтр по автору последнего модифицирования
        $mauthorArray = array();
        $filterMauthor = new XShopStandard();
        $filterMauthor->setGroupByQuery('mauthorid');
        while ($x = $filterMauthor->getNext()) {
            try {
                $user = Shop::Get()->getUserService()->getUserByID($x->getMauthorid());
                $mauthorArray[] = array(
                    'id' => $x->getMauthorid(),
                    'name' => $user->makeName()
                );
            } catch (Exception $e) {

            }
        }
        $this->setValue('mauthorArray', $mauthorArray);

        if ($this->getArgumentSecure('filter')) {
            $menu = new XShopStandard();

            if ($this->getArgumentSecure('filtername')) {
                $menu->addWhereQuery("name LIKE '%".$this->getArgumentSecure('filtername')."%'");
            }
            if ($this->getArgumentSecure('filtercauthor')) {
                $menu->filterCauthorid($this->getArgumentSecure('filtercauthor'));
            }
            if ($this->getArgumentSecure('filtermauthor')) {
                $menu->filterMauthorid($this->getArgumentSecure('filtermauthor'));
            }
            if ($this->getArgumentSecure('filteractive')) {
                $menu->filterActive($this->getArgumentSecure('filteractive'), '!=');
            } else {
                $menu->filterActive('1');
            }
            if ($this->getArgumentSecure('filterdatefromcreate')) {
                $menu->filterCdate($this->getArgumentSecure('filterdatefromcreate'), '>=');
            }
            if ($this->getArgumentSecure('filterdatetocreate')) {
                $menu->filterCdate($this->getArgumentSecure('filterdatetocreate'), '<=');
            }
            if ($this->getArgumentSecure('filterdatefromedit')) {
                $menu->filterMdate($this->getArgumentSecure('filterdatefromedit'), '>=');
            }
            if ($this->getArgumentSecure('filterdatetoedit')) {
                $menu->filterMdate($this->getArgumentSecure('filterdatetoedit'), '<=');
            }
            $ar = array();
            while ($x = $menu->getNext()) {
                $ar[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    'url' => Engine::GetLinkMaker()->makeURLByContentIDParam('standard-tpl', $x->getId()),
                    'selected' => $x->getId() == $this->getArgumentSecure('id'),
                    'urledit' => Engine::GetLinkMaker()->makeURLByContentIDParam('admin-standard-edit', $x->getId()),
                );
            }
            $this->setValue('filtermenu', $ar);
        } else {
            $menu = new XShopStandard();
            $menu->filterActive('1');
            $ar = array();
            while ($x = $menu->getNext()) {
                $ar[$x->getParentid()][] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    'url' => Engine::GetLinkMaker()->makeURLByContentIDParam('standard-tpl', $x->getId()),
                    'selected' => $x->getId() == $this->getArgumentSecure('id'),
                    'urledit' => Engine::GetLinkMaker()->makeURLByContentIDParam('admin-standard-edit', $x->getId()),
                );
            }
            $this->setValue('menu', $ar);
        }

        // список подстандартов
        if ($link) {
            $child = new XShopStandard();
            $child->filterParentid($link);
            $ch = array();
            while ($x = $child->getNext()) {
                $ch[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    'url' => Engine::GetLinkMaker()->makeURLByContentIDParam('standard-tpl', $x->getId()),
                    'urledit' => Engine::GetLinkMaker()->makeURLByContentIDParam('admin-standard-edit', $x->getId()),
                );
            }
            $this->setValue('childArray', $ch);
        }

    }

}