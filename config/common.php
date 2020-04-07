<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @file    common
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 30, 2012 10:38:22 AM
 */

if (isset($_SERVER['HTTP_APPNAME'])) { // on server
    define('ON_SERVER', true);

    define('DEBUG', true);

    define('UP_DOMAIN', 'xxxx');
} else {
    define('ON_SERVER', false);

    define('DEBUG', true);

    define('JS_VER', time());
    define('CSS_VER', time());
}

define('PATH_ROOT', dirname(__DIR__));

// all .env goes here
$envfile = PATH_ROOT . '/.env';
file_exists($envfile) or die("no env file $envfile");
$env = parse_ini_file($envfile, true);
define('URL_ROOT', isset($env['URL_ROOT']) ? $env['URL_ROOT'] : '');
define('ROOT', URL_ROOT . '/');
isset($env['DB']) or die("no DB in env");
define('DB_CONF', $env['DB']);
// end .env

// all config goes below

$config['site']['name'] = 'meme BBS';

$config['qq_login'] = array(
    'app_id' => '100311379',
    'app_key' => 'c1710d23e0230c9354a74658b6c7fd48',
    'scope' => implode(',', array('get_user_info')),
    'callback' => 'http://meme8.sinaapp.com/' . (ON_SERVER ? '' : 'meme/') . 'login',
);

if (ON_SERVER) {
    // 会覆盖之前的配置
    $config['db'] = array(
        'dsn' => 'mysql:' . implode(';', array('host=' . SAE_MYSQL_HOST_M, 'port=' . SAE_MYSQL_PORT, 'dbname=' . SAE_MYSQL_DB)),
        'dsn_s' => 'mysql:' . implode(';', array('host=' . SAE_MYSQL_HOST_S, 'port=' . SAE_MYSQL_PORT, 'dbname=' . SAE_MYSQL_DB)),
        'username' => SAE_MYSQL_USER,
        'pwd' => SAE_MYSQL_PASS,
    );
    include 'server.php';
}
