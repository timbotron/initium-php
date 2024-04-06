<?php

namespace Initium;

class Base {

    protected $db;
    protected $messages;

    public function __construct() {
        $this->db = new \Medoo\Medoo([
            'database_type' => 'mysql',
            'database_name' => DB_NAME,
            'server' => DB_SERVER,
            'username' => DB_USER,
            'password' => DB_PASS,
            'charset' => 'utf8',
            //'error' => \PDO::ERRMODE_SILENT, // when live, turn on for handling db issues, see User::create_user()
        ]);

        $this->messages = [];
        //var_dump("in base construct");

    }

    protected function return_code(int $http_code) {
        switch ($http_code) {
            case 400:
                header('HTTP/1.1 400 Bad Request');
                break;

            case 404:
                header("HTTP/1.0 404 Not Found");
                break;

            case 500:
                header('HTTP/1.1 500 Internal Server Error');
                break;
            
            default:
                // code...
                break;
        }

        // kill the request
        die;
    }

    protected function isUUID($uuid): bool {
        $regex = '/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[1-5][0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}$/';
        return preg_match($regex, $uuid) === 1;
    }

    protected function add_message($type, $value) {
        // types are error and info
        $this->messages[] = ['type' => $type, 'value' => $value];

        return true;
    }

    protected function get_messages(): array {
        $ret = $this->messages;
        $this->messages = [];
        return $ret;
    }

}
