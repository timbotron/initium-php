<?php

namespace Initium;

use League\Plates\Engine;

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

	public function login_page() {
		// just draw page
		$templates = new Engine(__DIR__ . '/../templates');
		$templates->addData(['page_title' => 'Initium PHP Login'], ['basic']);


		echo $templates->render('login', );

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
