# Deployer recipe

This repository contains a couple of the recipes we use for [deployer](https://github.com/deployphp/deployer) here @ eXolnet.

It provides the following:

- Install npm dependencies
- Install bower dependencies
- Run our grunt build system (less compilation + js concat/minification)
- Deploy laravel (supports environment)
-- Migrate database
-- Seed (if specified)
-- Make storage directories writable and in the shared/ folder.

## Getting started

In your deploy.php, you can use the following (assuming you have included the files provided in this repository in your project):

```
<?php
require_once 'exolnet.php';

set('writable_use_sudo', false);

server('production', 'prod.server.com')
	->user('www-data')
	->env('deploy_path', '/var/www/vhosts/domain.com')
	->env('laravel_env', 'production')
	->env('grunt_env', 'release')
	->pubkey('key.pub', 'key.priv');

set('repository', 'https://path.to/git-repository.git');
```

## License

The code is licensed under the [MIT license](http://choosealicense.com/licenses/mit/). See LICENSE.
