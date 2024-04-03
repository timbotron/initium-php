<?php

namespace Initium;

use Mailgun\Mailgun;

class Email {

	protected $mg;

	function __construct() {
		$this->mg = Mailgun::create(EMAIL_MAILGUN_KEY);

	}
	
    public function send_email($to, $subject, $text_body, $html) {
    	return $mg->messages()->send(EMAIL_MAILGUN_DOMAIN, [
		  'from'    => 'noreply@mail100.citracode.com',
		  'to'      => $to,
		  'subject' => $subject,
		  'text'    => $text_body,
		  'html'    => $html,
		]);
    }
}
