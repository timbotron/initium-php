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

	public function create_account_page() {
		// just draw page
		$this->templates->addData(['page_title' => SITE_NAME . ' Account Creation'], ['basic']);
		echo $this->templates->render('create_account', );

	}

	public function create_account() {
		// validate

		$v = new \Valitron\Validator($_POST);
		$v->rule('required', ['email']);
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

        var_dump($email->send_mailgun($_POST['email'], 'Welcome to '.SITE_NAME, 'Set/Reset Password here: '.$validate_url."\n\n-The ".SITE_NAME .' team', $email_html));


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
			// UUID not found, 404 it
			$this->return_code(400);
		}

		// just draw page
		$this->templates->addData(['page_title' => SITE_NAME . ' Change Password'], ['basic']);
		$this->templates->addData(['uuid' => $vars['pass_uuid']], ['reset_password_page']);
		echo $this->templates->render('reset_password_page', );
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
