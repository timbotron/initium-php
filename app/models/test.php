<?php

namespace Initium;

class Test extends Base {

    public static function go_here() {
        echo "you made it son\n";
    }

    public function test_instance($vars) {
        echo "instance!\n";
        var_dump($this->db, $vars);

        //$user = new User();

        //var_dump($user->create_user('email@email.com'));

        $email = new Email();

        var_dump($email->send_mailgun('tim.habersack@gmail.com', 'mah subject', 'email text content for text only fans', "<h3>hot darn</h3>\n<p>It is email time.</p>"));
    }
}
