# CakePHP Application Skeleton for PaaS / Heroku

__This is a fork of [CakePHP Application Skeleton](https://github.com/cakephp/app).__

A skeleton for creating applications with [CakePHP](http://cakephp.org) 3.0.

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation

1. Download [Composer](http://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist thegallagher/cakephp-app-paas [app_name]`.

If Composer is installed globally, run
```bash
composer create-project --prefer-dist thegallagher/cakephp-app-paas [app_name]
```

You should now be able to visit the path to where you installed the app and see
the setup traffic lights.

## Configuration

Configuration is done with environment variables or in `config/.env`.
You can read `config/.env` for information on the available variables.

You may use any of the constants in `config/paths.php` by
prefixing and suffixing the constant with two underscores (`__`).
Eg. To use the `LOGS` constant, write `__LOGS__` in the environment variable.

## Deploying to Heroku

Make sure you have the [Heroku toolbelt](https://toolbelt.heroku.com/) installed and logged in.

Create the app:
```bash
heroku apps:create
git push heroku master
heroku config:set SECURITY_SALT=[your-security-salt]
```

Create a MySQL database:
```bash
heroku addons:create cleardb
old_db_url=`heroku config:get CLEARDB_DATABASE_URL`
heroku config:set DATABASE_URL="$old_db_url"
```

Configure logs:
```bash
heroku config:set LOG_URL="console:///?levels[]=notice&levels[]=info&levels[]=debug"
heroku config:set LOG_ERROR_URL="console:///?levels[]=warning&levels[]=error&levels[]=critical&levels[]=alert&levels[]=emergency"
```

### Notes

- If you require multiple instances of your web process, you will need to
  configure your sessions to use database or cache.

## Credits

- Most of the code in this repository is from [CakePHP Application Skeleton](https://github.com/cakephp/app).
- A lot of ideas and code borrowed from [Friends Of Cake App Template](https://github.com/FriendsOfCake/app-template).