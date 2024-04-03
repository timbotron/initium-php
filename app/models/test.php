<?php

namespace Timh;

class Test {

    public function __construct() {
        $this->db = 'DATA';
    }

    public static function go_here() {
        echo "you made it son\n";
    }

    public function test_instance($vars) {
        echo "instance!\n";
        var_dump($this->db, $vars);
    }
}
