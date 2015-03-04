<?php

require_once __DIR__.'/composer.php';

set('shared_dirs', ['app/storage']);
set('shared_files',[]);
set('writable_dirs', [
	'app/storage',
	'app/storage/sessions',
	'app/storage/views',
	'app/storage/meta',
	'app/storage/logs',
	'app/storage/cache',
]);

option('seed', null, \Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL, 'Should we seed the database?');

task('laravel:database:migrate', function() {
	cd('{release_path}');
	run('php artisan migrate --env='.env('laravel_env'));
})->desc('Migrate database');

task('laravel:database:seed', function() {
	if ( ! input()->getOption('seed')) {
		return;
	}
	cd('{release_path}');
	run('php artisan db:seed --env='.env('laravel_env'));
})->desc('Seed database');

task('deploy:laravel', [
	'composer:setup',
	'composer:install',
	'laravel:database:migrate',
	'laravel:database:seed',
])->desc('Deploy a laravel project');
