<?php
/**
 * @copyright WebProduction
 * @package Finance
 */
class Finance_CronMinuteDefault implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        FinanceService::Get()->updateCategoriesCache();
    }

}