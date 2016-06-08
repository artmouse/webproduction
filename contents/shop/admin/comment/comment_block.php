<?php
class comment_block extends Engine_Class {

    /**
     *  Получить комментарии
     *
     * @return CommentsAPI_XComment
     */
    private function _getComments() {
        return $this->getValue('comments');
    }

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/admin/comment.js');

        $onPage = 50;
        $p = $this->getArgumentSecure('p');

        $userId = Shop::Get()->getUserService()->getUser();
        $level = $userId->getLevel();
        $id = $userId->getId();
        $mainKey = $this->getValue('mainKey');

        $comments = $this->_getComments();

        $commentsCount = $comments->getCount();
        $comments->setLimit($p * $onPage, $onPage);

        $a = array();
        $j = 0;
        while ($x = $comments->getNext()) {

            // если наш юзер админ или создатель, открываем доступ к редактированию
            if ($level == 3 || $id == $x->getId_user()) {
                $edit = true;
            } else {
                $edit = false;
            }

            if ($this->getValue('notCanEdit')) {
                $edit = false;
            }

            try {
                $user = Shop::Get()->getUserService()->getUserByID(
                    $x->getId_user()
                );

                $color = $user->makeColor();
                $userName = $user->makeName(true, 'lfm');
                $userURL = $user->makeURLEdit();
                $userID = $user->getId();

                $avatar = $user->makeImageThumb(200);

                $companyName = $user->getCompany();
                if ($user->getEmployer()) {
                    $companyName = false;
                }
            } catch (Exception $userEx) {
                $userName = false;
                $userURL = false;
                $userID = false;
                $color = 'gray';
                $companyName = false;
                $avatar = MEDIA_PATH . '/shop/stub-man.jpg';
            }

            $key = $x->getKey();
            if (preg_match("/^shop-order-(\d+)$/ius", $key, $r)) {
                $key = 'order-'.$r[1];

                try {
                    $order = Shop::Get()->getShopService()->getOrderByID($r[1]);
                } catch (Exception $e) {
                    $order = false;
                }
            }

            $content = $x->getContent();

            $type = $x->getType();
            if (!$type) {
                $type = 'comment';
            }

            if ($mainKey && $mainKey != $x->getKey()) {
                $type = 'change';

                if ($order) {
                    $content = '#'.$order->getId().' '.$content;
                }
            }

            // это мой комментарий или нет?
            try {
                $my = $x->getId_user() == $this->getUser()->getId();
            } catch (Exception $e) {
                $my = false;
            }

            $a[] = array(
            'id' => $x->getId(),
            'content' => Shop::Get()->getShopService()->formatComment($content, $key, ($j == 0), $x->getType()),
            'contentOriginal' => htmlspecialchars($x->getContent()),
            'datetime' => DateTime_Formatter::DateTimePhonetic($x->getCdate()),
            'color' => $color,
            'userName' => $userName,
            'userURL' => $userURL,
            'avatar' => $avatar,
            'userID' => $userID,
            'edit' => $edit,
            'type' => $type,
            'my' => $my,
            'companyName' => $companyName,
            );

            $j++;
        }
        $this->setValue('commentArray', $a);

        $ar = $this->_pages($p, $onPage, $commentsCount);

        $a = $ar['pagesArray'];
        $this->setValue('pagesArray', $a);
        if (isset($ar['urlnext'])) {
            $this->setValue('urlnext', $ar['urlnext']);
        }
        if (isset($ar['urlprev'])) {
            $this->setValue('urlprev', $ar['urlprev']);
        }
        if (isset($ar['hellip'])) {
            $this->setValue('hellip', $ar['hellip']);
        }
    }

    private function _pages($page, $onPage, $count) {
        $assignsArray = array();

        $a = array();
        $cnt = ceil($count / $onPage);

        $stop = $page + 3;
        $start = $page - 3;

        if ($stop > $cnt) {
            $stop = $cnt;
            $start = $stop - 5;
        }

        if ($start < 0) {
            $start = 0;
            $stop = $start + 5;
        }
        if ($stop > $cnt) {
            $stop = $cnt;
        }

        $urlCurrent = Engine::GetURLParser()->getTotalURL();
        $urlCurrent = preg_replace("/\/p-(\d+)\//ius", '/', $urlCurrent);
        $urlGET = Engine::GetURLParser()->getGETString();
        if ($urlGET) {
            $urlGET = '?' . $urlGET;
        }

        for ($j = $start; $j < $cnt; $j++) {
            $a[] = array(
                'name' => ($j + 1),
                'url' => $j > 0 ? $urlCurrent . 'p-' . $j . '/' . $urlGET : $urlCurrent . $urlGET,
                'selected' => $j == $page,
                'visible' => $j > $stop ? false : true,
            );
        }

        $assignsArray['pagesArray'] = $a;

        // next
        if ($page + 1 < $cnt) {
            $urlNext = $urlCurrent . 'p-' . ($page + 1) . '/' . $urlGET;

            $assignsArray['urlnext'] = $urlNext;

            Engine::GetHTMLHead()->addLink('next', Engine::Get()->getProjectURL() . $urlNext);
        }

        // prev
        if ($page - 1 >= 0) {
            if ($page - 1 > 0) {
                $urlPrev = $urlCurrent . 'p-' . ($page - 1) . '/' . $urlGET;
            } else {
                $urlPrev = $urlCurrent . $urlGET;
            }

            $assignsArray['urlprev'] = $urlPrev;

            Engine::GetHTMLHead()->addLink('prev', Engine::Get()->getProjectURL() . $urlPrev);
        }

        if ($stop - $start > 0) {
            $assignsArray['hellip'] = true;
        }

        return $assignsArray;
    }

}