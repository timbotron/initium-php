# InitiumPHP (archived monorepo)

![digital horizon, the sun peeking above the ground](https://file.citracode.com/i/initium-php/initium_php_logo_small.jpg "Initium PHP Logo")

> **⚠️ This repository is archived and read-only.** InitiumPHP has been
> repackaged as two Composer packages. This single-repo version is kept for
> history only — it no longer receives fixes. Start new projects from the
> skeleton below.

## Where the project lives now

InitiumPHP was split so it can be installed with Composer instead of cloned:

| Package | What it is |
|---|---|
| **[timbotron/initium-php-core](https://github.com/timbotron/initium-php-core)** ([Packagist](https://packagist.org/packages/timbotron/initium-php-core)) | The framework — HTTP kernel, routing, base classes, DB layer, auth, email, default templates/assets, migrations. Namespace `Initium\`. Installed as a dependency; not used on its own. |
| **[timbotron/initium-php-skeleton](https://github.com/timbotron/initium-php-skeleton)** ([Packagist](https://packagist.org/packages/timbotron/initium-php-skeleton)) | The boilerplate app that requires core. Namespace `App\`. This is what you start a new project from. |

### Start a new project

```bash
composer create-project timbotron/initium-php-skeleton myapp
```

Then fill in `config/_env.php`, import the migrations shipped with core, and point
your web root at `public/`. Framework fixes arrive with `composer update` — no
more cloning and hand-editing. Full setup and usage docs live in each package's
README.

## What this repo was

The original InitiumPHP: a small, dependency-light PHP starter with turnkey user
authentication (signups, password resets, Mailgun email), meant to be cloned as
the seed of a new small project. Everything here — the framework and a specific
app — lived in one repo, served from `www/`. That code has moved into the two
packages above (the framework into core, the app shell into the skeleton), with
`aaronholbrook/autoload` directory-scanning replaced by PSR-4 autoloading.

## Credits

Built on [FastRoute](https://packagist.org/packages/nikic/fast-route),
[League's Plates](https://packagist.org/packages/league/plates),
[Medoo](https://packagist.org/packages/catfan/medoo), and
[Valitron](https://packagist.org/packages/vlucas/valitron), plus the
[Furtive](https://github.com/johno/furtive) CSS microframework.

And the 13 fun-size bags of Skittles consumed while working on this in the
evenings. Taste the rainbow.

## License

Copyright 2024 Tim Habersack

InitiumPHP is released under an MIT license. http://opensource.org/licenses/MIT
