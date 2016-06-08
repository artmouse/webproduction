<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2011 WebProduction <webproduction.com.ua>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU LESSER GENERAL PUBLIC LICENSE
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 */

/**
 * Logger package.
 * Позволяет хранить и вести любое количество логов, отправлять логи
 * в файл, директорию, базы и т.д.
 *
 * Реестр логов - по строковому ключу.
 *
 * Разработчик может самостоятельно создать свой обработчик, реализуя
 * интерфейс Log_IHandler.
 * @see Log_IHandler
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Log
 */
class Log {

    /**
     * @var array of Log
     */
    private static $_Instance = array();

    /**
     * Получить логгер.
     * Возможно хранение нескольких логгеров по разным ключам ($loggerKey)
     * В случае использования ключа - логгер должен быть инициирован явно:
     * Если ключ не используется, ключ будет назван default.
     * @see Initialize()
     *
     * @package string $loggerKey
     * @return Log
     */
    public static function Get($loggerKey = false) {
        if (!$loggerKey) {
            $loggerKey = 'default';
        }

        if (!isset(self::$_Instance[$loggerKey])) {
            if ($loggerKey == 'default') {
                self::$_Instance[$loggerKey] = new self();
            }
        }

        if (!self::$_Instance[$loggerKey]) {
            throw new Log_Exception("Logger with key '{$loggerKey}' not found, please, call Initialize() before.");
        }

        return self::$_Instance[$loggerKey];
    }

    /**
     * Инициировать Log. Передается первый handler.
     * Далее через addHandler() можно добавлять еще обработчики.
     *
     * @param Log_IHandler $handler
     * @return Log
     */
    public static function Initialize($loggerKey = 'default', Log_IHandler $handler) {
        if (!$loggerKey) {
            $loggerKey = 'default';
        }

        self::$_Instance[$loggerKey] = new self();
        self::Get($loggerKey)->clearHandlers();
        self::Get($loggerKey)->addHandler($handler);
        return self::Get($loggerKey);
    }

    /**
     * @var array
     */
    private $_handlersArray = array();

    /**
     * Добавить обработчик лога
     *
     * @param Log_IHandler $handler
     */
    public function addHandler(Log_IHandler $handler) {
        $this->_handlersArray[] = $handler;
    }

    /**
     * Отправить указанную строку в log'и
     *
     * @throws Log_Exception
     * @param string $string
     */
    public function addString($string) {
        if (!$this->_handlersArray) {
            throw new Log_Exception("No handlers to listen log");
        }
        foreach ($this->_handlersArray as $handler) {
            $handler->addString($string);
        }
    }

    /**
     * Очистить все обработчики логов
     */
    public function clearHandlers() {
        $this->_handlersArray = array();
    }

}