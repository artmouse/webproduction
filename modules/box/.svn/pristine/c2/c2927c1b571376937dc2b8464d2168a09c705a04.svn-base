<?php
/**
 * Интерфейс для работы с Asterisk AMI
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   OneBox
 */
class AsteriskAMI {

    public function __construct($host, $port, $login, $password) {
        $this->_host = $host;
        $this->_port = $port;
        $this->_login = $login;
        $this->_password = $password;
    }

    /**
     * Отправить команду $action в AMI.
     * Параметр $timeout отвечает за задержку между fread и fwrite.
     *
     * @param string $action
     * @param array $paramArray
     * @param int $timeout
     *
     * @return string
     */
    public function command($action, $paramArray = false, $endOfCommand = false) {
        fputs($this->_socket, "Action: {$action}\r\n");
        if ($paramArray) {
            foreach ($paramArray as $key => $value) {
                fputs($this->_socket, "{$key}: {$value}\r\n");
            }
        }
        fputs($this->_socket, "\r\n");

        $data = '';
        while ($x = fgets($this->_socket, 1024)) {
            $status = socket_get_status($this->_socket);
            $data .= $x;

            if ($endOfCommand) {
                // если задано условие парсинга
                if (substr_count($x, $endOfCommand."\r\n")) {
                    break;
                }

            } elseif ($status['unread_bytes'] == 0) {
                // иначе просто когда закончились данные
                break;
            }
        }

        return $data;
    }

    /**
     * Подключиться к AMI
     *
     * @param int $timeout
     */
    public function connect($timeout = 3) {
        $this->_socket = fsockopen(
            $this->_host,
            $this->_port,
            $errno,
            $errstr,
            $timeout
        );

        if (!$this->_socket) {
            throw new ServiceUtils_Exception($errstr, $errno);
        }

        fputs($this->_socket, "Action: Login\r\n");
        fputs($this->_socket, "UserName: {$this->_login}\r\n");
        fputs($this->_socket, "Secret: {$this->_password}\r\n");
        fputs($this->_socket, "Events: off\r\n");
        fputs($this->_socket, "\r\n");
    }

    /**
     * Отключиться от AMI и закрыть соеденение.
     */
    public function disconnect() {
        fputs($this->_socket, "Action: Logoff\r\n\r\n");
        fclose($this->_socket);
    }

    private $_host;

    private $_port;

    private $_login;

    private $_password;

    private $_socket;

}