<?php

namespace Initium;

class Base {

    protected $db;

    public function __construct() {
        $this->db = new \Medoo\Medoo([
            'database_type' => 'mysql',
            'database_name' => DB_NAME,
            'server' => DB_SERVER,
            'username' => DB_USER,
            'password' => DB_PASS,
            'charset' => 'utf8'
        ]);
        //var_dump("in base construct");

    }

}
