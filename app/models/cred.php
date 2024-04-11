<?php

namespace Initium;

class Cred extends Base {

	public function __construct() {
		parent::__construct();

	}

	public function userDetails(): array | bool {
		// returns array of user detail from session if logged in, else false
	}

	public function login(string $email, string $password): bool {

		if(empty($password) || strpos($password, "\0") !== false
			|| strlen($password) > 200)
		{
			return false;
		}

		// password at least is sensical, lets look up user
		$user = $this->db->get("users", ['id','email','password'], ['is_active' => 1, 'email'=> $email]);

		return password_verify($password, $user['password']);

	}

	public function logout(): bool {
		session_unset(); 
		session_destroy(); 
		return true;
	}

}
