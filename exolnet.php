<?php

require_once 'recipe/common.php';
require_once __DIR__.'/laravel.php';

task('deploy:update_code', function () {
    $repository = get('repository');
    run("git clone --depth 1 --recursive -q $repository {release_path} 2>&1");
    run("chmod -R g+w {release_path}");
})->desc('Updating code');

task('npm:install', function() {
    cd('{release_path}');
    run('npm install');
})->desc('NPM install');

task('bower:install', function() {
    cd('{release_path}');
    run('bower install');
})->desc('Bower install');

task('grunt:build', function() {
    $mode = in_array(get('grunt_env'), ['debug']) ? 'debug' : 'release';
    cd('{release_path}');
    run('grunt build:'.$mode);
})->desc('Grunt build');


task('exolnet:deploy:writable', function () {
    cd('{release_path}');
    foreach (get('writable_dirs') as $dir) {
        run("mkdir -p $dir");
        run("chmod -R 0777 $dir");
        run("chmod -R g+w $dir");
    }
})->desc('Make writable dirs');

task('deploy:exolnet', [
    'npm:install',
    'bower:install',
    'grunt:build',
    'deploy:laravel',
])->desc('Deploy an eXolnet project');

task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'exolnet:deploy:writable',
    'deploy:exolnet',
    'deploy:symlink',
    'cleanup',
])->desc('Deploy a project');
