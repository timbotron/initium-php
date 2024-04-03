<?php

namespace Initium;



class User extends Base {

	// create user
	public function create_user($email) {

		$ret = $this->db->insert("users", [
	    	"email" => $email,
	    	"created_at" => date("Y-m-d"),
	    	"last_login" => "0000-00-00"
	    ]);

	    return $ret;
	}

	// set password

	// reset password email

	// login page

	// reset password page

	//

    public static function go_here() {
        echo "you made it son\n";
    }

    public function test_instance($vars) {
        echo "instance!\n";
        var_dump($this->db, $vars);
    }
}
