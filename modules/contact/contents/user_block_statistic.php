<?php
class user_block_statistic extends Engine_Class {

    /**
     * Обертка
     * 
     * @return User
     */
    private function _getUser() {
        return $this->getValue('user');
    }

    public function process() {
        $user = $this->_getUser();

        $this->setValue('userID', $user->getId());

        // кто автор
        try {
            $author = $user->getAuthor();
            $this->setValue('authorName', $author->makeName());
            $this->setValue('authorURL', $author->makeURLEdit());
            $this->setValue('authorId', $author->getId());
        } catch (Exception $e) {

        }

        // список контактов по которым собираем статистику
        $userIDArray = array($user->getId());
        if ($user->getTypesex() == 'company' && $user->getCompany()) {
            $other = Shop::Get()->getUserService()->getUsersAll();
            $other->setCompany($user->getCompany());
            while ($x = $other->getNext()) {
                $userIDArray[] = $x->getId();
            }
        }

        $callbacks = Shop::Get()->getCallbackService()->getCallbackAll();
        $callbacks->addWhereArray($userIDArray, 'userid');
        $this->setValue('totalCallback', $callbacks->getCount());

        $feedbacks = Shop::Get()->getFeedbackService()->getFeedbackAll();
        $feedbacks->addWhereArray($userIDArray, 'userid');
        $this->setValue('totalFeedback', $feedbacks->getCount());

        $comments = Shop::Get()->getShopService()->getProductCommentsAll();
        $comments->addWhereArray($userIDArray, 'userid');
        $this->setValue('totalComment', $comments->getCount());

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $this->setValue('box', true);

            // last events (one month)
            $events = $user->getEvents($user->getTypesex() == 'company');
            $events->setOrder('cdate', 'DESC');
            $events->setHidden(0);
            $events->setLimitCount(50);
            $ratingSum = 0;
            $ratingCount = 0;
            while ($x = $events->getNext()) {
                if ($x->getRating() > 0) {
                    $ratingCount ++;
                    $ratingSum += $x->getRating();
                }
            }

            if ($ratingCount > 0) {
                $this->setValue('rating', round($ratingSum / $ratingCount));
                $this->setValue('ratingValue', round($ratingSum / $ratingCount, 2));
            }
        }

        // дополнительные блоки от модулей
        $moduleBlockArray = Shop_ModuleLoader::Get()->getUserStatisticsBlockArray();
        $blockArray = array();
        foreach ($moduleBlockArray as $contentID) {
            $block = Engine::GetContentDriver()->getContent($contentID);
            $block->setValue('userIDArray', $userIDArray);
            $block->setValue('user', $user);

            $aclArray = $block->getField('role');

            $blockAcl = true;
            if ($aclArray) {
                foreach ($aclArray as $acl) {
                    if ($user->isDenied($acl)) {
                        $blockAcl = false;
                        break;
                    }
                }
            }
            if ($blockAcl) {
                $blockArray[] = $block->render();
            }
        }
        $this->setValue('moduleBlockArray', $blockArray);
    }

}