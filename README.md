

# InitiumPHP

![digital horizon, the sun peeking above the ground](https://file.citracode.com/i/initium-php/initium_php_logo_small.jpg "Initium PHP Logo")

## About

A simple PHP framework with built-in user authentication. Designed to be cloned for the beginning of many a small project.

## Features

* Standard stuff; utilizing a simple project structure.
* Keep it small; only a handful of packages used, and none of them have dependancies. 
* Ready to go; routes and pages are already set up, for easy pattern-matching to build something new.
* Turnkey Auth; complete authentication is built in. Signups, password resets, email triggers, etc.
* Mailgun support for password resets is built-in.

## Get Started

1. Use the included `.sql` file and run that on your desired database. 
2. Copy the `_env.php.template` to `_env.php` and update the values.


## Packages

Please note there are some in the `composer.json` that may not be relevant for your project; comment them out if you don't want to use.

### Routing

[Fastroute](https://packagist.org/packages/nikic/fast-route)

Great router used by many frameworks. 

Routes live in  `/www/index.php`

### Templates

[League's Plates](https://packagist.org/packages/league/plates)

Consise but robust template system.

### Database 

[Medoo](https://packagist.org/packages/catfan/medoo)

Very lightweight wrapper around the PDO methods, making working with databases quite enjoyable.

### Validation

[Valitron](https://packagist.org/packages/vlucas/valitron)

Seems like data validation coming from the user is always necessary. Spritely little package to help with it.


## Credits

Besides the packages above, I am using the [Furtive](https://github.com/johno/furtive) CSS Microframework.

I also credit the 13 fun-size bags of Skittles I ate while working on this in the evenings. 

Skittles. Taste the rainbow!

## License

Copyright 2024 Tim Habersack

InitiumPHP is released under an MIT license. http://opensource.org/licenses/MIT  
