<?php

task('composer:setup', function() {
	cd('{deploy_path}/shared');
	run('wget -nc http://getcomposer.org/composer.phar');
	run('php composer.phar self-update');
	run('ln -s {deploy_path}/shared/composer.phar {release_path}/composer.phar');
})->desc('Composer setup');

task('composer:install', function() {
	cd('{release_path}');
	run('php {deploy_path}/shared/composer.phar install');
})->desc('Composer install');
