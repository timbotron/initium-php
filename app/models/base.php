<?php

namespace Initium;

class Base {

    public function __construct() {
        $this->db = 'DATA';
        var_dump("in base construct");
    }
}
