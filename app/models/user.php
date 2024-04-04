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

	public function login_page() {
		// just draw page
		$templates = new \League\Plates\Engine(__DIR__ . '/../templates');
		$templates->addData(['page_title' => 'Initium PHP Login'], ['basic']);


		echo $templates->render('login', );

	}

	public function create_account_page() {
		// just draw page
		$templates = new \League\Plates\Engine(__DIR__ . '/../templates');
		$templates->addData(['page_title' => 'Initium PHP Login'], ['basic']);
		echo $templates->render('create_account', );

	}

	public function create_account() {
		// validate

		$v = new \Valitron\Validator($_POST);
		$v->rule('required', ['email']);
		$v->rule('email', 'email');
		if($v->validate()) {
		    echo "Yay! We're all good!";
		} else {
		    // Errors
		    print_r($v->errors());
		}

		//if good, create user
		//
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
