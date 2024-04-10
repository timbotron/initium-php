<?php

namespace Initium;

class User extends Base {

	protected $templates;

	public function __construct() {
		parent::__construct();
		$this->templates = new \League\Plates\Engine(__DIR__ . '/../templates');

	}

	protected function generate_uuid() {
	    $uuid = random_bytes(16);

	    $uuid[6] = chr(ord($uuid[6]) & 0x0f | 0x40);
	    $uuid[8] = chr(ord($uuid[8]) & 0x3f | 0x80);

	    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($uuid), 4));
	}

	// create user
	public function create_user($email, $uuid) {

		$ret = $this->db->insert("users", [
	    	"email" => $email,
	    	"created_at" => date("Y-m-d"),
	    	"last_login" => "0000-00-00",
	    	"password_reset" => $uuid,
	    	"is_active" => 0,
	    ]);

	    if($this->db->error) {
	    	// was an error, lets shove to messages
	    	$this->add_message('error', 'DB Error: ' . $this->db->error);
	    	return false;
	    }

	    return true;
	}

	public function login_page() {
		// just draw page
		$this->templates->addData(['page_title' => SITE_NAME . ' Login'], ['basic']);


		echo $this->templates->render('login', );

	}

	public function home_page() {
		// just draw page
		$this->templates->addData(['page_title' => SITE_NAME], ['basic']);
		echo $this->templates->render('home', );

	}

	public function create_account_page() {
		// just draw page
		$this->templates->addData(['page_title' => SITE_NAME . ' Account Creation'], ['basic']);
		echo $this->templates->render('create_account', );

	}

	public function create_account() {
		// validate

		$v = new \Valitron\Validator($_POST);
		$v->rule('required', ['email', 'email2']);
		$v->rule('email', 'email');
		$v->rule('equals', 'email', 'email2');
		if(!$v->validate()) {
		    // Errors
		    foreach($v->errors() as $err_section) {
		    	foreach($err_section as $e) {
		    		$this->add_message('error', $e);
		    	}
		    }

		    $this->templates->addData(['messages' => $this->get_messages()], ['basic']);
		    $this->templates->addData(['post_content' => $_POST], ['create_account']);
		    $this->create_account_page();
		    return true;
		}

		// validated, let's create
		$uuid = $this->generate_uuid();

		if(!$this->create_user($_POST['email'], $uuid)) {
			// create user failed
			$this->templates->addData(['messages' => $this->get_messages()], ['basic']);
		    $this->templates->addData(['post_content' => $_POST], ['create_account']);
		    $this->create_account_page();
		    return true;
		}

		$validate_url = SITE_URL . 'password-reset/'.$uuid;

		// actually good, lets send email
		$this->templates->addData(['reset_type' => 'new', 'page_title' => SITE_NAME, 'reset_link' => $validate_url], ['reset_password_email']);

		$email_html = $this->templates->render('reset_password_email');


		$email = new Email();

        $email->send_mailgun($_POST['email'], 'Welcome to '.SITE_NAME, 'Set/Reset Password here: '.$validate_url."\n\n-The ".SITE_NAME .' team', $email_html);

        $this->templates->addData(['page_title' => SITE_NAME], ['basic']);
		$this->templates->addData(['is_error' => 0, 'top_title' => "Created account", "page_message" =>"<p>Your account was successfully created. Please check your email for your confirmation and link to set your password.</p>"], ['general_message_page']);
		echo $this->templates->render('general_message_page', );


		//if good, create user
		//
	}

	public function forgot_password_page() {
		// just draw page
		$this->templates->addData(['page_title' => SITE_NAME], ['basic']);
		echo $this->templates->render('forgot_password_page', );

	}

	public function forgot_password() {
		// validate

		$v = new \Valitron\Validator($_POST);
		$v->rule('required', ['email']);
		$v->rule('email', 'email');
		if(!$v->validate()) {
		    // Errors
		    foreach($v->errors() as $err_section) {
		    	foreach($err_section as $e) {
		    		$this->add_message('error', $e);
		    	}
		    }

		    $this->templates->addData(['messages' => $this->get_messages()], ['basic']);
		    $this->templates->addData(['post_content' => $_POST], ['forgot_password_page']);
		    $this->forgot_password_page();
		    return true;
		}

		$user_id = $this->db->get('users','id', ['email'=>$_POST['email'], 'is_active' => 1]);

		if($user_id) {
			// actually found user, lets set uuid and trigger email
			$uuid = $this->generate_uuid();

			// update user record to have new uuid
			$this->db->update("users", ['password_reset' => $uuid], ['id' => $user_id]);
			$validate_url = SITE_URL . 'password-reset/'.$uuid;

		    // lets send email
			$this->templates->addData(['reset_type' => 'same', 'page_title' => SITE_NAME, 'reset_link' => $validate_url], ['reset_password_email']);

			$email_html = $this->templates->render('reset_password_email');

			$email = new Email();

	        $email->send_mailgun($_POST['email'], 'Reset Password for '.SITE_NAME, 'Set/Reset Password here: '.$validate_url."\n\n-The ".SITE_NAME .' team', $email_html);
		}


		// either way, show success-y page

		$this->templates->addData(['page_title' => SITE_NAME], ['basic']);
		$this->templates->addData(['is_error' => 0, 'top_title' => "New Password requested", "page_message" =>"<p>If your email exists in our system, you should receive an email with a password reset link soon.</p>"], ['general_message_page']);
		echo $this->templates->render('general_message_page', );

				//if good, create user
		//
	}

	public function reset_password_page($vars) {
		if(!$this->isUUID($vars['pass_uuid'])) {
			// is not a UUID
			$this->return_code(400);
		}

		// look up and see if uuid exists
		if(!$this->db->has('users',['password_reset'=>$vars['pass_uuid']])) {
			// UUID not found, 400 it
			$this->return_code(400);
		}

		// just draw page
		$this->templates->addData(['page_title' => SITE_NAME . ' Change Password'], ['basic']);
		$this->templates->addData(['uuid' => $vars['pass_uuid']], ['reset_password_page']);
		echo $this->templates->render('reset_password_page', );
	}

	public function reset_password($vars) {
		if(!$this->isUUID($vars['pass_uuid'])) {
			// is not a UUID
			$this->return_code(400);
		}

		$v = new \Valitron\Validator($_POST);
		$v->rule('required', ['password', 'password2']);
		$v->rule('lengthMin', 'password', 8);
		$v->rule('equals', 'password', 'password2');
		if(!$v->validate()) {
		    // Errors
		    foreach($v->errors() as $err_section) {
		    	foreach($err_section as $e) {
		    		$this->add_message('error', $e);
		    	}
		    }

		    $this->templates->addData(['messages' => $this->get_messages()], ['basic']);
		    $this->reset_password_page($vars);
		    return true;
		}

		// look up and see if uuid exists
		$user_id = $this->db->get('users','id', ['password_reset'=>$vars['pass_uuid']]);
		if(!$user_id) {
			// user not found, 400 it
			$this->return_code(400);
		}
		else {
			// found user so lets set password, wipte password hash and move on in life
			$password = password_hash($_POST["password"], PASSWORD_DEFAULT, ['cost' => 12]);
			
			if(!$this->db->update("users",["is_active" => 1, "password" => $password, "password_reset" => ''], ["id" => $user_id])) {
				// create user failed
				$this->templates->addData(['messages' => $this->get_messages()], ['basic']);
			    $this->reset_password_page($vars);
			    return true;
			}
			// just draw gen message
			$this->templates->addData(['page_title' => SITE_NAME], ['basic']);
			$this->templates->addData(['is_error' => 0, 'top_title' => "Password Changed Successfully", "page_message" =>"<p>Your password was changed successfully, please proceed to login.</p>\n"], ['general_message_page']);
			echo $this->templates->render('general_message_page', );

		}
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
