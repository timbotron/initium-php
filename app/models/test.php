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

        var_dump($email->send_email('tim.habersack@gmail.com', 'subject goes here', 'for the text lovers out thre', '<h2>hot darn email</h2>'));
    }
}
