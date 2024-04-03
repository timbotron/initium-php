<?php

ini_set('date.timezone', 'America/Los_Angeles');

// make directory put here be the root of project
define('PROJECT_ROOT', substr(__DIR__, 0,strpos(__DIR__, '/site_dir/')).'/site_dir');

\AaronHolbrook\Autoload\autoload( __DIR__ . '/../models' );

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    if ($diff->m > 0 || $diff->y > 0) {
        return date('M jS Y', strtotime($datetime));
    }

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
