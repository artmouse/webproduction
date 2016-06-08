<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * Событие на случай, когда появляется неотловленный exception
 *
 * @copyright WebProduction
 * @package   OneBox
 */
class Shop_EngineException implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $exception = $event->getException();

        if ($exception->getCode() == 404) {
            // для ошибки 40 направляем на страницу 404.
            // обычно это редкий случай, но тем не менее.

            // служебная информация
            ModeService::Get()->debug($exception);

            // пишем в лог
            LogService::Get()->add(array(404, $exception->getMessage()), '404');

            // отправляем на страницу 404
            Engine::Get()->getRequest()->setContentNotFound();
        } else {
            // иначе считаем что это не отловленная ошибка,
            // и пользователю будем показывать Internal Server Error,
            // а саму ошибку запишем в log.

            // служебная информация
            ModeService::Get()->debug($exception);

            $code = $exception->getCode();
            if (!$code) {
                $code = 500;
            }

            // пишем в лог
            LogService::Get()->add(array($code, $exception->getMessage()), 'exception');

            // отправляем на страницу 500
            Engine::Get()->getRequest()->setContentServerError();
            Engine::GetContentDriver()->getContent(Engine::Get()->getRequest()->getContentID())->setValue(
                'exception',
                print_r($exception, true)
            );
        }

        // заново формируем HTML-код ответа
        Engine::Get()->getResponse()->setBody(
            Engine::GetContentDriver()->getString(
                Engine::Get()->getRequest()->getContentID()
            )
        );
    }

}